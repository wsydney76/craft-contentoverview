<?php

namespace wsydney76\contentoverview\variables;

use craft\base\Component;
use wsydney76\contentoverview\Plugin;

class ContentOverviewVariable extends Component
{
    public function getSettings() {
        return Plugin::getInstance()->getSettings();
    }
}
