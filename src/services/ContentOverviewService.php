<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\helpers\ArrayHelper;
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\Plugin;

class ContentOverviewService extends Component
{

    public const EVENT_MODIFY_CONTENTOVERVIEW_QUERY = 'modifyContentoverviewQuery';

    public function getEntries($sectionSettings): array
    {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();
        $limit = $sectionSettings['limit'] ?? null;
        $orderBy = $sectionSettings['orderBy'] ?? null;
        $section = $sectionSettings['section'] ?? null;
        $imageField = $sectionSettings['imageField'] ?? null;
        $scope = $sectionSettings['scope'] ?? null;
        $status = $sectionSettings['status'] ?? null;
        $allSites = isset($sectionSettings['allSites']) ? $sectionSettings['allSites'] : false;


        $query = Entry::find()
            ->section($section)
            ->status(null);

        if ($limit) {
            $query->limit($limit);
        }

        if ($orderBy) {
            $query->orderBy($orderBy);
        }

        if ($status) {
            $query->status($status);
        }

        if ($allSites) {
            $query
                ->site('*')
                ->unique()
                ->preferSites([Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle)]);
        }

        if ($imageField) {
            $query->with([
                [$imageField, [
                    'withTransforms' =>  [$settings->transforms[$sectionSettings['layout'] ?? $settings->defaultLayout]]
                ]]
            ]);
        }

        switch ($scope) {
            case 'drafts': {
                $query->drafts(true);
                break;
            }
            case 'provisional': {
                $query
                    ->provisionalDrafts(true);
                break;
            }
            case 'all': {
                $query
                    ->provisionalDrafts(null)
                    ->drafts(null);
                break;
            }
        }

        if($scope && isset($sectionSettings['ownDraftsOnly']) && $sectionSettings['ownDraftsOnly'] ) {
            $query->draftCreator(Craft::$app->user->identity);
        }

        if ($this->hasEventHandlers(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY)) {
            $this->trigger(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY, new ModifyContentOverviewQueryEvent([
                'query' => $query,
                'sectionSettings' => $sectionSettings
            ]));
        }

        return [
            'entries' => $query->collect(),
            'count' => $query->count()
        ];

    }

    public function getTabConfig($tabId): ?array
    {
        $settings = Plugin::getInstance()->getSettings();
        return ArrayHelper::firstWhere($settings['tabs'], 'id', $tabId);
    }
}