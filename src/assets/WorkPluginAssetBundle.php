<?php

namespace wsydney76\contentoverview\assets;

use Craft;
use craft\web\AssetBundle;

/**
 * The work plugin does not offer a possibility to load css from outside, so we have to load it here.
 */
class WorkPluginAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = Craft::$app->plugins->getPlugin('work')->basePath . '/templates/css';
        $this->css = [
            'work.css'
        ];
    }
}