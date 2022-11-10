<?php

namespace wsydney76\contentoverview\controllers;

use Craft;
use craft\web\Controller;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;
use function explode;

class SectionController extends Controller
{
    public function actionGetSectionHtml()
    {
        // in the form of page-tabIndex-columnIndex-sectionIndex e.g. page1-1-1-0
        $sectionPath = Craft::$app->request->getRequiredBodyParam('sectionPath');
        $pageNo = Craft::$app->request->getRequiredBodyParam('pageNo');
        $q = Craft::$app->request->getBodyParam('q');

        $segments = explode('-', $sectionPath);

        $config = Craft::$app->config->getConfigFromFile("contentoverview/{$segments[0]}");

        if (!$config) {
            throw new InvalidConfigException("$sectionPath is an invalid path.");
        }

        /** @var Section $section */
        $section = $config['tabs'][$segments[1]]['columns'][$segments[2]]['sections'][$segments[3]];

        if (!$section->userCanView()) {
            throw new ForbiddenHttpException();
        }

        $results = $section->getEntries($pageNo, $q);

        return $this->asJson([
            'entriesHtml' => $this->view->renderTemplate('contentoverview/partials/section.twig', [
                'sectionConfig' => $section,
                'settings' => Plugin::getInstance()->getSettings(),
                'entries' => $results->getPageResults()
            ]),
            'paginateHtml' => $this->view->renderTemplate('contentoverview/partials/paginate.twig', [
                'sectionPath' => $sectionPath,
                'results' => $results
            ])
        ]);
    }
}