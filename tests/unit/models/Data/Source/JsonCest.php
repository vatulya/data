<?php

use Codeception\Util\Stub as StubUtil;

class JsonCest
{

    public function testPrepareData(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept('\Model\Data\Source\Json', 'prepareData');

        $data = [];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for empty data');

        $data = ['some data'];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for wrong data');

        $data = [
            [
                'BRL',
                'real brazylijski',
                '1,29',
                'world'
            ],
            [
                'PLN',
                'zloty polski',
                '1,0',
                'europe'
            ],
        ];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $expected = [
            [
                'code' => 'BRL',
                'name' => 'real brazylijski',
                'value' => 1.29,
                'group' => 'world',
            ],
            [
                'code' => 'PLN',
                'name' => 'zloty polski',
                'value' => 1,
                'group' => 'europe',
            ],
        ];
        $I->assertEquals($expected, $result, 'check prepareData for correct data');

    }

}