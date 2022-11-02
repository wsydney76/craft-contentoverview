<?php

namespace wsydney76\contentoverview\events;

use craft\elements\db\EntryQuery;
use yii\base\Event;

class ModifyContentOverviewQueryEvent extends Event
{
    public EntryQuery $query;
    public array $sectionSettings;
}