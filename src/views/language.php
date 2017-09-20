<?php
/*
 * Вывод списка языков для выбора пользователю
 */
use yii\helpers\Html;
use yii\helpers\Url;

$language = Yii::$app->language; //текущий язык
//Создаем массив ссылок всех языков с соответствующими GET параметрами
$array_lang = [
    'en' => Html::a('English', ['/language', 'lang' => 'en']),
    'ru' => Html::a('Русский', ['/language', 'lang' => 'ru']),
    'uk' => Html::a('Українська', ['/language', 'lang' => 'uk']),
];

//ссылку на текущий язык не выводим
if(isset($array_lang[$language])) unset($array_lang[$language]);
?>

<div class="language-ksl">
    <?php foreach ($array_lang as $lang) {
        echo ' '.$lang.' ';
    } ?>

</div>