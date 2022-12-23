<?php

namespace wsydney76\contentoverview\events;

use wsydney76\contentoverview\models\Section;
use yii\base\Event;

class GetSectionByPathEvent extends Event
{
    public string $sectionPath;
    public ?Section $section = null;
}