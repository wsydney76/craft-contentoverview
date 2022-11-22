<?php

namespace wsydney76\contentoverview\events;

use craft\elements\User;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Column;

class DefineSectionsEvent extends \yii\base\Event
{
    public User $user;
    public Column $column;
    public Collection $sections;
}