<?php

namespace klisl\languages\tests\models;

use klisl\languages\models\LanguageKsl;
use klisl\languages\tests\TestCase;


class LanguageKslTest extends TestCase
{

    public function testListLanguages()
    {
        $res = LanguageKsl::list_languages();
        $this->assertEquals($res, 'en|ru|uk|');
    }

    public function testparsingUrlWithDefaultLang()
    {
        $res = LanguageKsl::parsingUrl('ru', 'http://site.com/en');
        $this->assertEquals($res, 'http://site.com');
    }

    public function testparsingUrlWithAnotherLang()
    {
        $res = LanguageKsl::parsingUrl('uk', 'http://site.com/en');
        $this->assertEquals($res, 'http://site.com/uk');
    }
}