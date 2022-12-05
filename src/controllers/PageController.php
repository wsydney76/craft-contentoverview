<?php

namespace wsydney76\contentoverview\controllers;

use craft\web\Controller;
use InvalidArgumentException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use wsydney76\contentoverview\models\Settings;
use wsydney76\contentoverview\Plugin;
use yii\base\Exception;

class PageController extends Controller
{
    public $defaultAction = 'get-page';

    /**
     * Render a contentover view page by pageKey
     *
     * @param string $pageKey empty for default page
     * @return string The rendered page
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function actionGetPage(string $pageKey = ''): string
    {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();

        $page = Plugin::getInstance()->contentoverview->getPageByKey($pageKey);

        if (!$page) {
            throw new InvalidArgumentException("$pageKey is not a valid pageKey.");
        }

        return $this->view->renderPageTemplate('contentoverview/index.twig', [
            'page' => $page,
            'settings' => $settings
        ]);
    }
}