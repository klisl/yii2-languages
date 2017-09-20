<?php

namespace klisl\languages\controllers;

use Yii;
use yii\web\Controller;
use klisl\languages\LanguageKsl;


class LanguageController extends Controller
{

    public function actionIndex(){

        $language = Yii::$app->request->get('lang');

        //предыдущая страница
        $url_referrer = Yii::$app->request->referrer;

        if (!$url_referrer) $url_referrer = Yii::$app->request->hostInfo . '/'. $language;

        /*
         * Разбивает URL на подмассив $match_arr по рег.выражению
         * Пример для URL http://yiitest.loc/en/contact:
         * 0. http://yiitest.loc/en/contact
         * 1. http://yiitest.loc
         * 2. en
         * 3. ? или /
         * 4. оставшаяся часть (contact)
         */
        $list_languages = LanguageKsl::$url_language; //список языков

        $host = Yii::$app->request->hostInfo;

        preg_match("#^($host)/($list_languages)*(\?|/)*(.*)#",$url_referrer, $match_arr);

        if($language != LanguageKsl::$default_language){
            // замена идентификатора языка
            $match_arr[2] = '/'.$language;
            if(empty($match_arr[3]) && $match_arr[4]){
                $match_arr[3] = '/';
            }
        } else {
            $match_arr[2] = null;
        }

        // создание нового URL
        $url = $match_arr[1].$match_arr[2].$match_arr[3].$match_arr[4];
        // перенаправление
        Yii::$app->response->redirect($url);
    }
}
