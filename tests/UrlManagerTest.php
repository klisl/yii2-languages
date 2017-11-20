<?php

namespace klisl\languages\tests;

use Yii;


class UrlManagerTest extends TestCase
{

    protected $urlManager;

    protected function setUp()
    {
        parent::setUp();

        Yii::$app->language = 'en'; //метка языка для тестирования

        $urlManager = Yii::$app->urlManager;
        /*
         * Используется для работы компонента UrlManager
         * (часть после домена)
         */
        $urlManager->setScriptUrl('');

        $this->urlManager = $urlManager;
    }


    public function testCreateUrlParamNull()
    {
        $res = $this->urlManager->createUrl(null);
        $this->assertEquals($res, '/en');
    }

    public function testCreateUrlParamNotNull()
    {
        $res = $this->urlManager->createUrl('/params');
        $this->assertEquals($res, '/en/params');
    }

    public function testCreateUrlParamLang()
    {
        $res = $this->urlManager->createUrl(['lang' =>'ru']);

        $this->assertEquals($res, '/?lang=ru');

    }

}