<?php

namespace klisl\languages\models;

use Yii;


/**
 * Class LanguageKsl
 * @package klisl\languages\models
 */
class LanguageKsl
{

    /** @var  string строка вида ru|uk|en| */
    static $list;


    /**
     * Преобразование к строке вида ru|uk|en|
     * для использования в регулярных выражениях
     * @return string
     */
    public static function list_languages(){

        if(!self::$list){

            $languages = Yii::$app->getModule('languages')->languages;
            $list = '';

            array_walk($languages, function ($value) use (&$list){
                $list .= $value . '|';
            });
            self::$list = $list;
        }

        return self::$list;
    }


    /**
     * Создает URL с меткой языка
     * Разбивает URL на подмассив $match_arr
     * 0. http://site.loc/ru/contact
     * 1. http://site.loc
     * 2. ru или uk или en
     * 3. остальная часть
     *
     * @param string $language
     * @param string $url_referrer
     * @return string
     */
    public static function parsingUrl($language, $url_referrer){

        $list_languages = self::list_languages(); //список языков
        $host = Yii::$app->request->hostInfo;

        preg_match("#^($host)/($list_languages)(.*)#", $url_referrer, $match_arr);

        //добавляем разделитель
        if (isset($match_arr[3]) && !empty($match_arr[3]) && !preg_match('#^\/#', $match_arr[3])){
            $separator = '/';
        } else {
            $separator = '';
        }


        $default_language = Yii::$app->getModule('languages')->default_language;
        $show_default = Yii::$app->getModule('languages')->show_default;

        //Удаляем основной язык из URL, если в настройках выбрано "не показывать"
        if($language == $default_language && !$show_default){
            $match_arr[2] = null;
        } else {
            $match_arr[2] = '/'.$language.$separator;
        }

        // создание нового URL
        $url = $match_arr[1].$match_arr[2].$match_arr[3];
        return $url;
    }
}