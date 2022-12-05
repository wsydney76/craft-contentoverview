<?php

namespace wsydney76\contentoverview\assets;

use craft\web\AssetBundle;

class ContentOverviewAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@wsydney76/contentoverview/assets/dist';

        $this->css = [
            'cpstyles.css'
        ];

        $this->js = [
            'cpscripts.js'
        ];

        parent::init();
    }
}