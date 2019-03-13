<?php
/*
 * Добавляет указатель языка в ссылки
 */
namespace klisl\languages;

use Yii;

/**
 * Class UrlManager
 * @package klisl\languages
 */
class UrlManager extends \yii\web\UrlManager {

    /**
     * @param array|string $params
     * @return string
     */
    public function createUrl($params) {

        $module = Yii::$app->getModule('languages');
        //Сссылка(без идентификатора языка)
        $url = parent::createUrl($params);

        $curentLang = Yii::$app->language;

        if (empty($params['lang']) && $curentLang != $module->default_language) {
            //Добавляем к URL префикс - буквенный идентификатор языка
            if ($url == '/') {
                return '/' . $curentLang;
            } else {
                return '/' . $curentLang . $url;
            }
        };

        return $url;
    }
}