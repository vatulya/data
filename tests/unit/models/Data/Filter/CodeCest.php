<?php

use Codeception\Util\Stub as StubUtil;

class CodeCest
{

    const CLASS_FULL_NAME = '\Model\Data\Filter\Code';

    public function testFilterWithEmptyValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => null,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for wrong data');

        $data = [
            ['code' => 'abc'],
            ['code' => 'abcdef'],
            ['code' => '123'],
            ['code' => ''],
            ['code' => 'bbb'],
            ['code' => 'b'],
        ];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for correct data');
    }

    public function testFilter(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 'b',
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with empty value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with empty value for wrong data');

        $data = [
            ['code' => 'abc'],
            ['code' => 'abcdef'],
            ['code' => '123'],
            ['code' => ''],
            ['code' => 'bbb'],
            ['code' => 'b'],
        ];
        $result = $stub->filter($data);
        $expected = [
            ['code' => 'b'],
        ];
        $I->assertEquals($expected, array_values($result), 'check code filter with empty value for correct data');
    }

    public function testSetValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('');
        $I->assertEquals('', $I->getProtectedProperty($stub, 'value'), 'check empty value for empty string');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(false);
        $I->assertEquals('', $I->getProtectedProperty($stub, 'value'), 'check empty value for false');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(0);
        $I->assertEquals('0', $I->getProtectedProperty($stub, 'value'), 'check empty value for 0 int');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue([]);
        $I->assertEquals('', $I->getProtectedProperty($stub, 'value'), 'check empty value for empty array');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('abc');
        $I->assertEquals('abc', $I->getProtectedProperty($stub, 'value'), 'check value for string');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(123);
        $I->assertEquals('123', $I->getProtectedProperty($stub, 'value'), 'check empty value for 123 int');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(['abc']);
        $I->assertEquals('', $I->getProtectedProperty($stub, 'value'), 'check empty value for array');

    }

}