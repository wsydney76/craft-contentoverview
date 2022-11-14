<?php

namespace wsydney76\contentoverview\widgets;

use Craft;
use craft\base\Widget;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\Plugin;

class ContentOverviewLinksWidget extends Widget
{
    public static function displayName(): string
    {
        return Craft::t('contentoverview', Plugin::getInstance()->getSettings()->pluginTitle) . ' Links';
    }

    public static function icon(): ?string
    {
        return '@appicons/field.svg';
    }

    public function getBodyHtml(): ?string
    {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();
        $pages = $settings->getPages();

        return Craft::$app->view->renderTemplate('contentoverview/widgets/linkswidget.twig', [
            'pages' => $pages->map(function($page, $pageKey) {
                return Plugin::getInstance()->contentoverview->createPage(
                    $pageKey,
                    ['label' => $page['label'], 'url' => $page['url']]
                );
            })
        ]);
    }
}