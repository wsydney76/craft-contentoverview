<?php

namespace wsydney76\contentoverview\events;

use Illuminate\Support\Collection;
use yii\base\Event;

class DefinePagesEvent extends Event
{
    public Collection $pages;
}