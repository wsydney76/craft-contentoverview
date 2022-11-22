<?php

namespace wsydney76\contentoverview\events;

use craft\elements\db\ElementQueryInterface;
use yii\base\Event;

class FilterContentOverviewQueryEvent extends Event
{
    public ElementQueryInterface $query;
    public string $handle;
    public mixed $value;
}