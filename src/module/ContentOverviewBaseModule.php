<?php

namespace wsydney76\contentoverview\module;

use Craft;
use yii\base\Module;

class ContentOverviewBaseModule extends Module
{
    public function init()
    {
        Craft::setAlias('@modules/contentoverview', $this->getBasePath());
        Craft::setAlias('@comodule', $this->getBasePath());


        if (!$this->isActive()) {
            return;
        }

        parent::init();



        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
        });
    }

    /**
     * Check if the plugin should be active.
     *
     * This is done to avoid some overhead and unexpected errors if it is run without the expected environment.
     *
     * Add this at the beginning of your modules' init method:
     *
     * if (!$this->isActive()) {
     *      return;
     * }
     *
     *
     *
     * @return bool
     */
    public function isActive()
    {
        // Do not run if it is a frontend or console request
        if (!Craft::$app->request->isCpRequest) {
            return false;
        }

        // Do not run if we are on the login page
        if (Craft::$app->request->getIsLoginRequest()) {
            return false;
        }

        // Do not run if there is no current user
        if (!Craft::$app->user->identity) {
            return false;
        }

        return true;
    }

    protected function attachEventHandlers() : void
    {

    }
}