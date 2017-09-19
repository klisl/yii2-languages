<?php
/*
 * Добавляет указатель языка в ссылки на сайте
 */
namespace klisl\languages;

use Yii;

class UrlManager extends \yii\web\UrlManager {

    public function createUrl($params) {
        if (empty($params['lang'])) {
            $params['lang'] = Yii::$app->language;;
        }
        return parent::createUrl($params);
    }
}
