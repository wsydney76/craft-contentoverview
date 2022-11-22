<?php

namespace wsydney76\contentoverview\events;

use craft\elements\User;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Tab;
use yii\base\Event;

class DefineColumnsEvent extends Event
{
    public User $user;
    public Tab $tab;
    public Collection $columns;
}