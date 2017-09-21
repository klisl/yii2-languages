<?php

namespace klisl\languages;

use Yii;
use yii\base\BootstrapInterface;
use klisl\languages\LanguageKsl;



class Bootstrap implements BootstrapInterface{

    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {

        /*
         * Добавим правило маршрутизации для подключения
         * метода actionIndex контроллера модуля
         */
        $app->getUrlManager()->addRules([
            'language' => 'languages/language/index',
        ], false);


        /*
         * Включаем перевод сообщений
         */
        $app->i18n->translations['app'] =  [
            'class' => 'yii\i18n\PhpMessageSource',
            //'forceTranslation' => true,
            'basePath' => '@common/messages',
        ];

        /*
         * Установит нужный язык в параметры до выполнения запроса
         */
        $app->on(yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
            (new LanguageKsl())->run();
        });


        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле frontend/config/main.php
         */
         $app->setModule('languages', 'klisl\languages\Module');

    }
}