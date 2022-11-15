<?php

namespace wsydney76\contentoverview\events;

use yii\base\Event;

class DefineCustomFilterOptionsEvent extends Event
{
    public array $filter;
}