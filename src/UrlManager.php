<?php
/*
 * Добавляет указатель языка в ссылки на сайте
 */
namespace klisl\languages;
use Yii;
use klisl\languages\models\LanguageKsl;

class UrlManager extends \yii\web\UrlManager {

    public function createUrl($params) {

        if (empty($params['lang'])) {
//            dump(LanguageKsl::$default_language);
            if(Yii::$app->language != LanguageKsl::$default_language) $params['lang'] = Yii::$app->language;;
        }
        return parent::createUrl($params);
    }
}
