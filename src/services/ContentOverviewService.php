<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;

class ContentOverviewService extends Component
{
    public function getEntries(string $section, $sectionSettings, $scope = 'published')
    {
        $site = Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle);
        $limit = $sectionSettings['limit'] ?? null;
        $orderBy = $sectionSettings['orderBy'] ?? null;

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

        return $query->collect();

    }
}