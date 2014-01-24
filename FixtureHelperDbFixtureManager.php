<?php

Yii::import('system.test.CDbFixtureManager');

class FixtureHelperDbFixtureManager extends CDbFixtureManager
{

    /**
     * Overriden to be able to specify basePath before actually initializing
     */
    public function init()
    {
        CApplicationComponent::init();
    }

}