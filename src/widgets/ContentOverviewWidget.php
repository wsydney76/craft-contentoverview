<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;

class ContentOverviewWidget extends Widget
{
    public static function displayName(): string
    {
        return Craft::t('contentoverview', 'Content Overview');
    }

    public static function icon(): ?string
    {
        return Craft::getAlias('@appicons/field.svg');
    }

    public function getBodyHtml(): ?string
    {

        return Craft::$app->view->renderTemplate('contentoverview/contentoverview-widget');
    }
}





