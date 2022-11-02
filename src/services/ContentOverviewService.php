<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;

class ContentOverviewService extends Component
{

    public const EVENT_MODIFY_CONTENTOVERVIEW_QUERY = 'modifyContentoverviewQuery';

    public function getEntries($sectionSettings)
    {
        $site = Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle);
        $limit = $sectionSettings['limit'] ?? null;
        $orderBy = $sectionSettings['orderBy'] ?? null;
        $section = $sectionSettings['handle'] ?? null;
        $scope = $sectionSettings['scope'] ?? null;
        $status = $sectionSettings['status'] ?? null;


        $query = Entry::find()
            ->section($section)
            ->status(null)
            ->editable(true)
            ->site('*')
            ->unique()
            ->preferSites([$site]);

        if ($limit) {
            $query->limit($limit);
        }

        if ($orderBy) {
            $query->orderBy($orderBy);
        }

        if ($status) {
            $query->status($status);
        }

        switch ($scope) {
            case 'drafts': {
                $query->drafts(true);
                break;
            }
            case 'provisionaluser': {
                $query
                    ->provisionalDrafts(true)
                    ->draftCreator(Craft::$app->user->identity);
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
}