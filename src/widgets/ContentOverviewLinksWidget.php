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
        return '@coicons/field.svg';
    }

    public function getBodyHtml(): ?string
    {
        // This can occur if a user that had the permission to access this plugin has lost the permission in the mean time.
        if (!Craft::$app->user->identity->can('accessPlugin-contentoverview')) {
            return 'No permission';
        }

        /** @var Settings $service */
        $service = Plugin::getInstance()->contentoverview;
        $pages = $service->getPages();

        return Craft::$app->view->renderTemplate('contentoverview/widgets/linkswidget.twig', [
            'pages' => $pages->map(function($page, $pageKey) use ($service) {
                return $service->createPage(
                    $pageKey,
                    ['label' => $page['label'], 'url' => $page['url']]
                );
            })
        ]);
    }
}