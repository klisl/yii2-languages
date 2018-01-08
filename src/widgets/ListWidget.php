<?php

namespace klisl\languages\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class ListWidget
 * @package klisl\languages\widgets
 */
class ListWidget extends Widget{

    /** @var array */
    public $array_languages;


    /** @return void */
    public function init() {

        parent::init();

        $language = Yii::$app->language; //текущий язык

        //Создаем массив ссылок всех языков с соответствующими GET параметрами
        $array_lang = [];
        foreach (Yii::$app->getModule('languages')->languages as $key => $value){

            $link = $this->createLink($key, $value);
            $array_lang += [$value => $link];
        }

        //ссылку на текущий язык не выводим
        if(isset($array_lang[$language])) unset($array_lang[$language]);
        $this->array_languages = $array_lang;

    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     */
    protected function createLink($key, $value){
        return Html::a($key, ['languages/default/index', 'lang' => $value], ['class' => 'language '.$value] );
    }


    /**
     * @return string
     */
    public function run() {

        return $this->render('list',[
            'array_lang' => $this->array_languages
        ]);
    }

}
