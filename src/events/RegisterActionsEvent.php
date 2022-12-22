<?php

namespace wsydney76\contentoverview\events;

use yii\base\Event;

class RegisterActionsEvent extends Event
{
    /**
     * Register with key
     *
     * @var array
     */
    public array $actions;
}