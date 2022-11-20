<?php

namespace wsydney76\contentoverview\events;

use craft\elements\Entry;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Section;
use yii\base\Event;

class DefineActionsEvent extends Event
{
    public Entry $entry;
    public Section $sectionConfig;
    public Collection $actions;
}