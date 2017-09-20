<?php
/*
 * Вывод списка языков для выбора пользователю
 */
use yii\helpers\Html;
use yii\helpers\Url;

$language = Yii::$app->language; //текущий язык
//Создаем массив ссылок всех языков с соответствующими GET параметрами
$array_lang = [
    'en1' => Html::a('English', ['languages', 'lang' => 'en']),
    'en' => Html::a('English', [Url::to(['languages/language/index']), 'lang' => 'en']),
    'ru' => Html::a('Русский', [Url::to(['languages/language/index']), 'lang' => 'ru']),
//    'ru' => Html::a('Русский', ['language', 'lang' => 'ru']),
//    'ru' => '<a href="Url::to([\'languages/language/index\'])">Русский</a>',

    'uk' => Html::a('Українська', [Url::to(['languages/language/index']), 'lang' => 'uk']),
//    'uk' => Html::a('Українська', ['language?lang=uk']),
//    'uk' => '<a href="http://yiitest2.loc/language?lang=uk">Українська</a>',

];
//ссылку на текущий язык не выводим
if(isset($array_lang[$language])) unset($array_lang[$language]);
?>

<div class="language-ksl">
    <?php foreach ($array_lang as $lang) {
        echo ' '.$lang.' ';
    }
    echo Yii::$app->urlManager->createUrl(['languages/language/index']);
    ?>

</div>