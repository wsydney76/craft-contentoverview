<?php

namespace wsydney76\contentoverview\events;

use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Tab;
use yii\base\Event;

class DefineColumnsEvent extends Event
{
    public Tab $tab;
    public Collection $columns;
}