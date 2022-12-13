<?php

namespace wsydney76\contentoverview\controllers;

use Craft;
use craft\web\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use wsydney76\contentoverview\Plugin;
use yii\base\Exception;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class SectionController extends Controller
{
    /**
     * Return entries/pagination HTML for a section
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function actionGetSectionHtml(): Response
    {
        // in the form of page-tabIndex-columnIndex-sectionIndex e.g. page1-1-1-0
        $sectionPath = Craft::$app->request->getRequiredBodyParam('sectionPath');

        // Get additional parameters
        $sectionPageNo = Craft::$app->request->getRequiredBodyParam('sectionPageNo');
        $q = Craft::$app->request->getBodyParam('q');
        $filters = Craft::$app->request->getBodyParam('filters');
        $orderBy = Craft::$app->request->getBodyParam('orderBy');

        // Get section config
        $section = Plugin::getInstance()->contentoverview->getSectionByPath($sectionPath);

        // Execute query
        $results = $section->getEntries([
            'sectionPageNo' => $sectionPageNo,
            'q' => $q,
            'filters' => $filters,
            'orderBy' => $orderBy
        ]);

        // Render html
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

    /**
     * Render help html for section/entry
     *
     * @return Response
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws InvalidConfigException
     */
    function actionGetActionHelp(): Response
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

        $template =  '_contentoverview/' . Craft::$app->request->getRequiredParam('template');

        return $this->renderTemplate($template, [
            'sectionConfig' => $sectionConfig,
            'entry' => $entry
        ]);
    }

    /**
     * Render help html for a section
     *
     * @return Response
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws InvalidConfigException
     */
    function actionGetSectionHelp(): Response
    {
        $sectionPath = Craft::$app->request->getRequiredParam('sectionPath');
        $sectionConfig = Plugin::getInstance()->contentoverview->getSectionByPath($sectionPath);
        if (!$sectionConfig) {
            throw new InvalidConfigException("Invalid section path $sectionPath");
        }

        $template = '_contentoverview/' . Craft::$app->request->getRequiredParam('template');

        return $this->renderTemplate($template, [
            'sectionConfig' => $sectionConfig
        ]);
    }
}