<?php

namespace wsydney76\contentoverview\variables;

use craft\base\Component;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\Plugin;

class ContentOverviewVariable extends Component
{
    public function getSettings()
    {
        return Plugin::getInstance()->getSettings();
    }


    public function normalizeSectionConfig($sectionConfig)
    {
        if ($sectionConfig instanceof Section) {
            return $sectionConfig;
        }

        return new Section($sectionConfig);
    }

}
