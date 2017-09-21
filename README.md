yii2-languages
=================

Пакет для создания мультиязычного сайта на php-фреймворке Yii-2. Текущий язык отображается в URL (кроме основного языка):

* http://site.com
* http://site.com/en
* http://site.com/uk

Смена языка осуществляется при нажатии на соответствующие ссылки. Так же, язык можно менять прямо в адресной строке. Не используются сессии и куки. Простой код, рассчитанный на максимальное быстродействие.

Данное расширение устанавливает текущую локализацию приложения в зависимости от выбранного вами языка. 


  
Установка
------------------
* Установка расширения с помощью Composer.

```
composer require klisl/yii2-languages 
```


* Внести изменения в файл **frontend\config\main.php**:


(1)  в массив "return" вставить:
```php
'sourceLanguage' => 'ru', // использовать в качестве ключей переводов
```

(2) в массиве "components" есть вложенный массив "request", вставить в него:
```php
'baseUrl' => '', // убрать frontend/web
```

(3) в компоненте приложения "urlManager" включаем ЧПУ для ссылок, подключаем класс UrlManager данного расширения 
и дублируем  правила (массив 'rules') – вставить перед каждой строкой правила такое же с указанием метки языка. Например:
```php
'urlManager' => [
	'enablePrettyUrl' => true,
	'showScriptName' => false,
	'class' => 'klisl\languages\UrlManager',
	'rules' => [

		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/' => 'site/index',
		'/' => 'site/index',
	
		//пагинация
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/page-<page:\d+>/' => 'post/index',
		'page-<page:\d+>/' => 'post/index',
 
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
 
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<action:(contact|login|logout|about|signup)>' => 'site/<action>',
		'/<action:(contact|login|logout|about|signup)>' => 'site/<action>',
 
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
 
		'<lang:' . \klisl\languages\LanguageKsl::$url_language . '>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
	]
],
```

(4) в шаблон **frontend\views\layouts\main.php** или нужный вид вставить вывод переключения языков:
```php
<?php
    //вывод ссылок для смены языка
    echo $this->renderFile(Yii::getAlias('@klisl/languages/views/language.php'));
?>
```



Использование
-------------

#### Перевод фраз.
Для перевода отдельных слов и фраз (пунктов меню например), нужно создать языковые файлы в папке common/messages. Количество языковых файлов будет столько, сколько у вас дополнительных языков для перевода, не считая основного. Например, если используется русский, украинский и английский, то создаем папки “en” и “uk” при условии, что русский является основным языком. Метка основного языка не отображается в URL. 

Напоминаю, что основной язык задается в файле frontend\config\main.php, в массиве «return» строкой
**'sourceLanguage' => 'ru',**

Пример языкового файла common\messages\en\app.php:
```php
<?php
return [
    'Блог' => 'Blog',
    'О нас' => 'About me',
    'Контакты' => 'Contact',
];
```
то есть в массив "return" нужно вписать все слова и фразы которые нужно переводить. 
Аналогично нужно создать файл common\messages\uk\app.php для украинского языка.

В коде (обычно в шаблонах и файлах представлений), фразы которые требуют перевода заключать в вызов метода **Yii::t()**.
Согласно нашей конфигурации так: 
```php
Yii::t('app', 'Блог')
```
Русский у нас указан в качестве языка по-умолчанию, поэтому если текущий язык – русский, выведется слово «Блог», а если английский - 'Blog'.


#### Перевод статичных страниц.
Статичные страницы - это страницы, которые хранят текст в самом файле (в коде), а не берут контент из базы данных. Целые страницы содержат слишком много текста, в связи с чем нецелесообразно использовать метод Yii::t().

В нужном контроллере создаем действие для каждой такой страницы:
```php
public function actionStat()
{
    $language = Yii::$app->language; //текущий язык
    //выводим вид соответствующий текущему языку
    return $this->render('statPages/stat-'.$language);     
}
```
то есть вторая часть название файла вида берется из названия языка. 
В данном случае в папке с видами создаем отдельную папку для статичных файлов statPages (это не обязательно), а в ней файлы с контентом соответствующего языка:
- stat-ru.php
- stat-uk.php
- stat-en.php


#### Перевод статей хранящих контент в базе данных.

Для настройки базы данных и моделей выполнить действия указанные в данной статье статье: <http://klisl.com/multilingual_BD.html>.  



Мой блог: [klisl.com](http://klisl.com)  