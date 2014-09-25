<?php

use Codeception\Util\Stub as StubUtil;

class PhpCest
{

    public function testPrepareData(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept('\Model\Data\Source\Php', 'prepareData');

        $data = [];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for empty data');

        $data = ['some data'];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for wrong data');

        $data = [
            'europe' => [
                'PLN' => [
                    'name' => 'zloty polski',
                    'value' => 1.0,
                ],
                'EUR' => [
                    'name' => 'euro',
                    'value' => 4.15,
                ],
            ],
        ];
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $expected = [
            [
                'group' => 'europe',
                'code' => 'PLN',
                'name' => 'zloty polski',
                'value' => 1.0,
            ],
            [
                'group' => 'europe',
                'code' => 'EUR',
                'name' => 'euro',
                'value' => 4.15,
            ],
        ];
        $I->assertEquals($expected, $result, 'check prepareData for correct data');

    }

}