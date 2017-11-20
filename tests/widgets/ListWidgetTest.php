<?php

namespace klisl\languages\tests\widgets;

use klisl\languages\tests\TestCase;
use klisl\languages\widgets\ListWidget;


class ListWidgetTest extends TestCase
{

    public function testInit()
    {

        \Yii::$app->language = 'uk'; //метка языка для тестирования

        $mockListWidget = $this->getMockBuilder(ListWidget::class)
            ->disableOriginalConstructor()
            //метод будет возвращать Null если не переопределить
            ->setMethods(['createLink'])
            ->getMock();

        $mockListWidget
            //метод отработает минимум 1 раз
            ->expects($this->atLeastOnce())
            //переопределяем возвращаемое значение этого метода
            ->method('createLink')
            ->will($this->returnValue('http://site.com/en'));


        $mockListWidget->init();

        $result = $mockListWidget->array_languages; //результат выполнения метода сохраняется в свойство

        $this->assertCount( 2, $result);
        $this->assertArrayNotHasKey('uk', $result);
    }


}
