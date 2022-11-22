<?php

namespace wsydney76\contentoverview\events;

use craft\elements\Entry;
use craft\elements\User;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Section;
use yii\base\Event;

class DefineFiltersEvent extends Event
{
    public User $user;
    public Section $sectionConfig;
    public Collection $filters;
}