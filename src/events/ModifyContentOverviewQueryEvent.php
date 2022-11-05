<?php

namespace wsydney76\contentoverview\events;

use craft\elements\db\EntryQuery;
use wsydney76\contentoverview\models\Section;
use yii\base\Event;

class ModifyContentOverviewQueryEvent extends Event
{
    public EntryQuery $query;
    public Section $sectionSettings;
}