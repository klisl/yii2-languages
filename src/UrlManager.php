<?php
/*
 * Добавляет указатель языка в ссылки
 */
namespace klisl\languages;

use Yii;

class UrlManager extends \yii\web\UrlManager {

    public function createUrl($params) {

        //Получаем сформированную ссылку(без идентификатора языка)
        $url = parent::createUrl($params);

        if (empty($params['lang'])) {
            //текущий язык приложения
            $curentLang = Yii::$app->language;

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