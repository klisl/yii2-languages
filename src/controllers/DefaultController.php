<?php

namespace klisl\languages\controllers;

use Yii;
use yii\web\Controller;
use klisl\languages\models\LanguageKsl;


/**
 * Class DefaultController
 * @package klisl\languages\controllers
 */
class DefaultController extends Controller
{

    /**
     * Обрабатывает переход по ссылкам для смены языка
     * Перенаправляет на ту же страницу с новым URL.
     *
     * @return void
     */
    public function actionIndex()
    {

        $language = Yii::$app->request->get('lang'); //язык на который будем менять


        $url_referrer = Yii::$app->request->get('url');

        if(!$url_referrer) $url_referrer = Yii::$app->request->referrer; //предыдущая страница

        /*
         * Если все же предыдущая страница не получена - возвращаем на главную.
         */
        if (!$url_referrer) $url_referrer = Yii::$app->request->hostInfo . '/'. $language;

        //устанавливает/меняет метку языка
        $url = LanguageKsl::parsingUrl($language, $url_referrer);

        Yii::$app->response->redirect($url);
    }

}
