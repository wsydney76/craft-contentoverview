<?php

namespace wsydney76\contentoverview\events;

use craft\elements\db\ElementQueryInterface;
use yii\base\Event;

class ModifyContentOverviewQueryEvent extends Event
{
    public ElementQueryInterface $query;
}