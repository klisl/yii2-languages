<?php

namespace klisl\languages\tests;

use Yii;


class RequestTest extends TestCase
{

    protected $request;

    protected function setUp()
    {
        parent::setUp();

        Yii::$app->language = 'en'; //метка языка для тестирования

        $request = Yii::$app->request;

        $this->request = $request;
    }


    public function testGetLangUrlWithoutLang()
    {
        $_SERVER['REQUEST_URI'] = ''; //без метки языка
        $clearRequest = $this->request->getLangUrl();
        $this->assertEquals($clearRequest, '');
    }

    public function testGetLangUrlWithLang()
    {
        $_SERVER['REQUEST_URI'] = '/en'; //с меткой языка
        $clearRequest = $this->request->getLangUrl();
        $this->assertEquals($clearRequest, '');
    }

}