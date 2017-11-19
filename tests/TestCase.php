<?php

namespace klisl\languages\tests;


use klisl\languages\Module;
use klisl\languages\Request;
use klisl\languages\tests\widgets\DefaultController;
use klisl\languages\UrlManager;
use yii\console\Application;

/**
 * Class TestCase
 * @package klisl\languages\tests
 * Используется для создания и удаления приложения Yii2 перед каждым тестом.
 */

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    protected function mockApplication()
    {

        new Application([
            'id' => 'app-test',
            'basePath' => __DIR__,
            'modules' => [
                'languages' => [
                    'class' => Module::class,
                    //Языки используемые в приложении
                    'languages' => [
                        'English' => 'en',
                        'Русский' => 'ru',
                        'Українська' => 'uk',
                    ],
                    'default_language' => 'ru', //основной язык (по-умолчанию)
                ],
            ],
            'components' => [
                'request' => [
                    'csrfParam' => '_csrf-test',
                    'baseUrl' => '',  //чтобы убрать frontend/web
                    'hostInfo' => 'http://site.com', //т.к. недоступна $_SERVER['SERVER_NAME']
                    'class' => Request::class
                ],
                'urlManager' => [
                    'enablePrettyUrl' => true, //не отображать index.php?r=
                    'class' => UrlManager::class,
                ],
            ],
        ]);

    }

    protected function destroyApplication()
    {
        \Yii::$app = null;
    }
}
