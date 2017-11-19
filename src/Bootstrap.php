<?php

namespace klisl\languages;

use Yii;
use yii\base\BootstrapInterface;
use klisl\languages\models\LanguageKsl;
use yii\web\NotFoundHttpException;


class Bootstrap implements BootstrapInterface{

    //Метод, который вызывается автоматически при каждом запросе
    public function bootstrap($app)
    {
		
		if(YII_ENV == 'test') return; //для тестового приложения отключаем.

        /*
         * Включаем перевод сообщений
         */
        $app->i18n->translations['app'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            //'forceTranslation' => true,
            'basePath' => '@app/common/messages',
        ];

        $this->run($app);

    }


    public function run($app){
	
        $module = Yii::$app->getModule('languages');

        $url = $app->request->url;

        //Получаем список языков в виде строки
        $list_languages = LanguageKsl::list_languages();

        preg_match("#^/($list_languages)(.*)#", $url, $match_arr);

        //Если URL содержит указатель языка - сохраняем его в параметрах приложения и используем
        if (isset($match_arr[1]) && $match_arr[1] != '/' && $match_arr[1] != ''){

            /*
             * Если в настройках выбрано не показывать язык используемый по-умолчанию
             * убираем метку текущего языка из URL и перенаправляем на ту же страницу
             */
            if( !$module->show_default && $match_arr[1] == $module->default_language) {
                $url = $app->request->absoluteUrl; //Возвращает абсолютную ссылку
                $lang = $module->default_language; //язык используемый по-умолчанию
                $app->response->redirect(['languages/default/index', 'lang' => $lang, 'url' => $url]);
            }

            $app->language = $match_arr[1];
            $app->formatter->locale = $match_arr[1];
            $app->homeUrl = '/'.$match_arr[1];

            /*
             * Если URL не содержит указатель языка и отключен показ основного языка в URL
             */
        } elseif(!$module->show_default){

            $lang = $module->default_language; //язык используемый по-умолчанию

            $app->language = $lang;
            $app->formatter->locale = $lang;

            /*
             * Если URL не содержит указатель языка, а в настройках включен показ основного языка
             */
        } else {
            $url = $app->request->absoluteUrl; //Возвращает абсолютную ссылку

            $lang = $module->default_language;

            $app->response->redirect(['languages/default/index', 'lang' => $lang, 'url' => $url], 301);
        }
    }
}