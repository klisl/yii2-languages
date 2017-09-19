<?php

namespace klisl\languages;

use Yii;
use yii\base\BootstrapInterface;



class Bootstrap implements BootstrapInterface{

    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {

        //Правила маршрутизации
        $app->getUrlManager()->addRules([
            'lang' => 'languages/language/index',
//            'statistics/forms' => 'statistics/stat/forms',
        ], false);

//        $app->setComponents(
//            ['urlManager' => ['class' => 'klisl\languages\UrlManager']]);
//        dump($app);

//        echo 1;
//    dump($app->getUrlManager());

//        $app->sourceLanguage = 'ru'; // использован в качестве ключей переводов


        $app->i18n->translations['app'] =  [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'forceTranslation' => true,
//                    "sourceLanguage" => "ru",
                    'basePath' => '@common/messages',
                ];



//        dump($app->i18n);
        /*
         * Регистрация модуля в приложении
         * (вместо указания в файле frontend/config/main.php
         *  'modules' => [
         *      'statistics' => 'Klisl\Statistics\Module'
         *  ],
         */
         $app->setModule('languages', 'klisl\languages\Module');


    }
}