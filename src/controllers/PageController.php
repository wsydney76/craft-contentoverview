<?php

namespace wsydney76\contentoverview\controllers;

use Craft;
use craft\web\Controller;

use InvalidArgumentException;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\Plugin;

class PageController extends Controller
{
    public $defaultAction = 'get-page';

    public function actionGetPage(string $pageKey = '')
    {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();

        $pageKey = $pageKey ?: $settings->defaultPage;

        $pageConfig = $settings->getPages()->get($pageKey);

        if (!$pageConfig) {
            throw new InvalidArgumentException("$pageKey is not a valid pageKey.");
        }

        $page = Plugin::getInstance()->contentoverview->createPage($pageKey, $pageConfig);

        return $this->view->renderPageTemplate('contentoverview/index.twig', [
            'title' => Craft::t('site', $settings->pluginTitle),
            'page' => $page,
            'settings' => $settings
        ]);
    }
}