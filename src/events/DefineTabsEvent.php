<?php

namespace wsydney76\contentoverview\events;

 use Illuminate\Support\Collection;
 use wsydney76\contentoverview\models\Page;
 use yii\base\Event;

 class DefineTabsEvent extends Event
{
    public Page $page;
    public Collection $tabs;
}