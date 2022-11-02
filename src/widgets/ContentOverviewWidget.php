<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;
use wsydney76\contentoverview\Plugin;

class ContentOverviewWidget extends Widget
{
    public static function displayName(): string
    {
        return Craft::t('contentoverview', Plugin::getInstance()->getSettings()->navLabel);
    }

    public static function icon(): ?string
    {
        return '@appicons/field.svg';
    }

    public function getBodyHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('contentoverview/contentoverview-widget.twig');
    }
}