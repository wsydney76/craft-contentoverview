<?php

namespace wsydney76\contentoverview\controllers;

use Craft;
use craft\enums\Color;
use craft\web\Controller;
use Illuminate\Support\Collection;
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
            'settings' => $settings,
            'colors' => Color::cases(),
            'crumbs' => $this->crumbs($settings),
        ]);
    }

    public function crumbs(Settings $settings): ?array
    {
        if (!$settings->showBreadCrumbs) {
            return null;
        }

        $crumbs = [];

        // Add root:
        $crumbs[] = [
            'label' => Craft::t('site', $settings->pluginTitle),
            'url' => 'contentoverview',
        ];

        $pages = Plugin::getInstance()->contentoverview->getPages();

        if ($pages) {
            $crumbs[] = [
                'menu' => [
                    'label' => Craft::t('site', 'Select page'),
                    'items' => $pages
                        ->filter(fn($page) => $page->pageKey !== '')
                        ->map(fn($page) => [
                        'label' => Craft::t('site', $page->label),
                        'url' => $page->url,
                        'selected' => $page->url === Craft::$app->request->pathInfo ||
                            (Craft::$app->request->pathInfo === 'contentoverview' && $page->pageKey === $settings->defaultPage)
                            ,
                    ])->toArray(),
                ],
            ];
        }



        // Gather other widget types and generate a disclosure-menu-compatible list:
//        $allTypes = Collection::make(Craft::$app->getEntries()->getEditableSections());
//        $typeOptions = $allTypes->map(fn( $wt) => [
//            'label' => Craft::t('site', $wt->name),
//            'url' => "entries/$wt->handle",
//            // Is this the current type?
//            'selected' => $wt->id === $type->id,
//        ])->toArray();
//
//        // Add this widget type’s source, with a switcher for other widget type indexes:
//        $crumbs[] = [
//            // Note that we don’t need a top-level label or URL—Craft uses the `selected` menu item!
//            'menu' => [
//                'label' => Craft::t('site', 'Select widget type'),
//                'items' => $typeOptions,
//            ],
//        ];

        return $crumbs;
    }
}