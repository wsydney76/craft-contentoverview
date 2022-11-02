<?php

namespace wsydney76\contentoverview\variables;

use craft\base\Component;
use craft\elements\Entry;
use wsydney76\contentoverview\Plugin;

class ContentOverviewVariable extends Component
{
    public function getSettings()
    {
        return Plugin::getInstance()->getSettings();
    }

    public function getEntries($sectionSettings)
    {
       return Plugin::getInstance()->contentoverviewService->getEntries($sectionSettings);
    }
}
