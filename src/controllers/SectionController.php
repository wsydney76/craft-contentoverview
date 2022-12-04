<?php

namespace wsydney76\contentoverview\controllers;

use Craft;
use craft\web\Controller;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;

class SectionController extends Controller
{
    public function actionGetSectionHtml()
    {
        // in the form of page-tabIndex-columnIndex-sectionIndex e.g. page1-1-1-0
        $sectionPath = Craft::$app->request->getRequiredBodyParam('sectionPath');
        $sectionPageNo = Craft::$app->request->getRequiredBodyParam('sectionPageNo');
        $q = Craft::$app->request->getBodyParam('q');
        $filters = Craft::$app->request->getBodyParam('filters');
        $orderBy = Craft::$app->request->getBodyParam('orderBy');

        $section = Plugin::getInstance()->contentoverview->getSectionByPath($sectionPath);

        $results = $section->getEntries([
            'sectionPageNo' => $sectionPageNo,
            'q' => $q,
            'filters' => $filters,
            'orderBy' => $orderBy
        ]);

        return $this->asJson([
            'entriesHtml' => $this->view->renderTemplate("contentoverview/partials/{$section->entriesTemplate}", [
                'sectionConfig' => $section,
                'settings' => Plugin::getInstance()->getSettings(),
                'sectionPath' => $sectionPath,
                'entries' => $results->getPageResults(),
                'sectionPageNo' => $sectionPageNo,
                'orderBy' => $orderBy,
                'transform' => $section->getTransform()
            ]),
            'paginateHtml' => $this->view->renderTemplate('contentoverview/partials/paginate.twig', [
                'sectionPath' => $sectionPath,
                'results' => $results
            ])
        ]);
    }

    function actionGetActionHelp(): \yii\web\Response
    {
        $sectionPath = Craft::$app->request->getRequiredParam('sectionPath');
        $sectionConfig = Plugin::getInstance()->contentoverview->getSectionByPath($sectionPath);
        if (!$sectionConfig) {
            throw new InvalidConfigException("Invalid section path $sectionPath");
        }

        $entryId = Craft::$app->request->getRequiredParam('entryId');
        $entry = Craft::$app->entries->getEntryById($entryId);
        if (!$entry) {
            throw new InvalidCallException("Invalid entry id $entryId");
        }

        $template = Plugin::getInstance()->getSettings()->customTemplatePath . '/' . Craft::$app->request->getRequiredParam('template');


        return $this->renderTemplate($template, [
            'sectionConfig' => $sectionConfig,
            'entry' => $entry
        ]);
    }

    function actionGetSectionHelp(): \yii\web\Response
    {
        $sectionPath = Craft::$app->request->getRequiredParam('sectionPath');
        $sectionConfig = Plugin::getInstance()->contentoverview->getSectionByPath($sectionPath);
        if (!$sectionConfig) {
            throw new InvalidConfigException("Invalid section path $sectionPath");
        }
        $template = Plugin::getInstance()->getSettings()->customTemplatePath . '/' . Craft::$app->request->getRequiredParam('template');
        return $this->renderTemplate($template, [
            'sectionConfig' => $sectionConfig
        ]);
    }
}