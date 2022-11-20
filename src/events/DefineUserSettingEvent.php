<?php

namespace wsydney76\contentoverview\events;

use yii\base\Event;

class DefineUserSettingEvent extends Event
{
    public string $key;
    public mixed $value;
}