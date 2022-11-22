<?php

namespace wsydney76\contentoverview\events;

use craft\elements\User;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Filter;
use yii\base\Event;

class DefineCustomFilterOptionsEvent extends Event
{
    public User $user;
    public Filter $filter;
    public Collection $options;
}