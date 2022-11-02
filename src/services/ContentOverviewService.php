<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;

class ContentOverviewService extends Component
{
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
            case 'provisional': {
                $query
                    ->provisionalDrafts(true)
                    ->draftCreator(Craft::$app->user->identity);
                ;

                break;
            }
        }

        return $query->collect();

    }
}