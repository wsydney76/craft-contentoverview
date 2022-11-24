<?php

namespace wsydney76\contentoverview\assets;

use craft\web\AssetBundle;
use wsydney76\contentoverview\Plugin;

class ContentOverviewAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@wsydney76/contentoverview/assets/dist';

        $useCSS = Plugin::getInstance()->getSettings()->getUserSetting('useCSS');

        $this->css = match ($useCSS) {
            'modern' => ['cpstyles.css', 'cpstyles-modern.css'],
            default => ['cpstyles.css', 'cpstyles-legacy.css', 'cpstyles-modern.css'],
        };

        $this->js = [
            'cpscripts.js'
        ];

        parent::init();
    }


}