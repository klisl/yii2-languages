<?php
/*
 * Класс подключается перед запуском приложения по событию beforeRequest
 * из frontend\config\main.php и устанавливает язык приложения
 *
 */
namespace klisl\languages;

use Yii;


class LanguageKsl
{
    static $url_language = 'ru|uk|en'; //используемые языки
    static $default_language = 'ru'; //основной язык (по-умолчанию)

    public function run(){
        $url = Yii::$app->request->url;

        $list_languages = self::$url_language;
        preg_match("#^/($list_languages)(.*)#", $url, $match_arr);

        //Если URL содержит указатель языка - сохраняем его в параметрах приложения и используем
        if (isset($match_arr[1]) && $match_arr[1] != '/'){
            Yii::$app->language = $match_arr[1];
            Yii::$app->formatter->locale = $match_arr[1];
            Yii::$app->homeUrl = '/'.$match_arr[1];

            /*
             * Если URL не содержит указатель языка (например главная страница)-
             * делаем перенаправление на ее же + добавляем GET параметр языка
             */
        } else {
            $lang = self::$default_language;
            Yii::$app->response->redirect(['site/language', 'lang' => $lang]);
        }
    }
}