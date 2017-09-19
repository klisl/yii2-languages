<?php

namespace klisl\languages\controllers;

use Yii;
use yii\web\Controller;
//use klisl\languages\Models\KslStatistic;
use common\languages\LanguageKsl;


class LanguageController extends Controller
{

//    public function index(){
//        return $this->render('language');
//    }

    public function actionIndex(){

        dump('actionRun');
        exit;
        $language = Yii::$app->request->get('lang');

        //предыдущая страница
        $url_referrer = Yii::$app->request->referrer;
        if (!$url_referrer) $url_referrer = Yii::$app->request->hostInfo . '/'. $language;

        /*
         * разбивает URL на подмассив $match_arr
         * 0. http://site.loc/ru/contact
         * 1. http://site.loc
         * 2. ru или uk или en
         * 3. остальная часть
         */
        $list_languages = LanguageKsl::$url_language; //список языков

        preg_match("#^(http.*)/($list_languages)(.*)#",$url_referrer, $match_arr);

        // замена идентификатора языка
        $match_arr[2] = '/'.$language;

        // создание нового URL
        $url = $match_arr[1].$match_arr[2].$match_arr[3];
        // перенаправление
        Yii::$app->response->redirect($url);

    }

}
