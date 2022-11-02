<?php

namespace wsydney76\contentoverview\models;

use craft\base\Model;

class Settings extends Model
{
    public $navLabel = 'Content Overview';
    public $tabs = [];
    public $widgetText = 'Get a quick overview of your content';
    public $linkTarget = '_blank';
}