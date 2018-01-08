<?php

namespace klisl\languages;


use yii\base\Module as BaseModule;


/**
 * Class Module
 * @package klisl\languages
 */
class Module extends BaseModule
{

    public $controllerNamespace = 'klisl\languages\controllers';

    public $languages; //Языки используемые в приложении

    public $default_language; //основной язык (по-умолчанию)

    public $show_default; //показывать в URL основной язык

}
