<?php

namespace wsydney76\contentoverview\events;

use craft\elements\User;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\TableSection;
use yii\base\Event;

class DefineTableColumnsEvent extends Event
{
    public User $user;
    public TableSection $table;
    public Collection $tableColumns;
}