<?php

namespace wsydney76\contentoverview\events;

use craft\elements\Asset;
use craft\elements\Entry;
use wsydney76\contentoverview\models\Section;
use yii\base\Event;

class DefineIconEvent extends Event
{
    public Entry $entry;
    public ?string $icon = null;
    public ?string $iconBgColor = null;
}