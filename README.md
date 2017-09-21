yii2-languages
=================

Пакет для создания мультиязычного сайта на фреймворке Laravel-5. Текущий язык отображается в URL (кроме основного языка):

* http://site.com
* http://site.com/en
* http://site.com/uk

Смена языка осуществляется при нажатии на соответствующие ссылки. Так же, язык можно менять прямо в адресной строке. Не используются сессии и куки. Простой код, рассчитанный на максимальное быстродействие.

Данный пакет устанавливает текущую локализацию приложения в зависимости от выбранного вами языка. 


  
Установка
------------------
* Установка расширения с помощью Composer.

```
composer require klisl/yii2-languages 
```


* Внести изменения в файл frontend\config\main.php:


(1)  в массив return вставить:
```php
'sourceLanguage' => 'ru', // использовать в качестве ключей переводов
```

(2) в массиве 'components' вложенный массив «request», вставить в него:
```php
'baseUrl' => '', // убрать frontend/web
```

(3) в компоненте 'urlManager' включаем ЧПУ для ссылок, подключаем класс UrlManager расширения 
и дублируем  правила (массив 'rules') – вставить перед каждой строкой правила такое же с указанием метки языка. Например:
```php
'urlManager' => [
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'class' => 'klisl\languages\UrlManager',
	'rules' => [

		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/' => 'site/index',
		'/' => 'site/index',
	
		//пагинация для главной страницы выводимой post/index
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/page-<page:\d+>/' => 'post/index',
		'page-<page:\d+>/' => 'post/index',
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/' => 'post/index',
		'/' => 'post/index',

		[
			'pattern'=> '<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<url\w+>',
			'route' => 'post/view',
			'suffix' => '.html',
		],
		[
			'pattern'=> '/<url\w+>',
			'route' => 'post/view',
			'suffix' => '.html',
		],

		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<action:(contact|login|logout|language|about|signup)>' => 'site/<action>',
		'/<action:(contact|login|logout|language|about|signup)>' => 'site/<action>',

		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
	]
],
```

(4) в шаблон frontend\views\layouts\main.php или нужный вид вставить вывод переключения языков:
```php
<?php
    //вывод ссылок для смены языка
    echo $this->renderFile(Yii::getAlias('@klisl/languages/views/language.php'));
?>
```





Использование
-------------

* Разместить (переопределить метод behaviors) в контроллерах ответственных за вывод страниц по которым нужно собирать статистику:
```
public function behaviors()
{
    return [

        'statistics' => [
            'class' => \Klisl\Statistics\AddStatistics::class,
            'actions' => ['index', 'contact'],
        ],
…

```


Мой блог: [klisl.com](http://klisl.com)  