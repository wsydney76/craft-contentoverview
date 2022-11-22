<?php

namespace wsydney76\contentoverview\events;

use craft\elements\User;
use Illuminate\Support\Collection;
use yii\base\Event;

class DefinePagesEvent extends Event
{
    public User $user;
    public Collection $pages;
}