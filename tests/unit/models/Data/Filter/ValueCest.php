<?php

use Codeception\Util\Stub as StubUtil;

class ValueCest
{

    const CLASS_FULL_NAME = '\Model\Data\Filter\Value';

    public function testFilterWithEmptyValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 0,
            'rangeMin' => 0,
            'rangeMax' => 0,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for wrong data');

        $data = [
            ['value' => 'abc'],
            ['value' => '123'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with empty value for correct data');
    }

    public function testFilterWithMinRange(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 0,
            'rangeMin' => 0.2,
            'rangeMax' => 0,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with min range value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with min range value for wrong data');

        $data = [
            ['value' => 'abc'],
            ['value' => '123'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $result = $stub->filter($data);
        $expected = [
            ['value' => '123'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $I->assertEquals($expected, array_values($result), 'check code filter with min range value for correct data');
    }

    public function testFilterWithMaxRange(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 0,
            'rangeMin' => 0,
            'rangeMax' => 0.6,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with max range value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with max range value for wrong data');

        $data = [
            ['value' => 'abc'],
            ['value' => '123'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $result = $stub->filter($data);
        $expected = [
            ['value' => 'abc'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
        ];
        $I->assertEquals($expected, array_values($result), 'check code filter with max range value for correct data');
    }

    public function testFilterWithMinRangeAndMaxRange(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 0,
            'rangeMin' => 0.2,
            'rangeMax' => 1.5,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with min and max range value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with min and max range value for wrong data');

        $data = [
            ['value' => 'abc'],
            ['value' => '123'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $result = $stub->filter($data);
        $expected = [
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $I->assertEquals($expected, array_values($result), 'check code filter with min and max range value for correct data');
    }

    public function testFilterWithValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'filter', [
            'value' => 1.23,
            'rangeMin' => 0,
            'rangeMax' => 0,
        ]);

        $data = [];
        $result = $stub->filter($data);
        $I->assertEquals($data, $result, 'check code filter with value for empty data');

        $data = ['some data'];
        $result = $stub->filter($data);
        $I->assertEquals([], $result, 'check code filter with value for wrong data');

        $data = [
            ['value' => 'abc'],
            ['value' => '123'],
            ['value' => ''],
            ['value' => '0'],
            ['value' => '0.50'],
            ['value' => 1.23],
        ];
        $result = $stub->filter($data);
        $expected = [
            ['value' => 1.23],
        ];
        $I->assertEquals($expected, array_values($result), 'check code filter with value for correct data');
    }

    public function testSetValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for empty string');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for empty string');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for empty string');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(false);
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for false');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for false');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for false');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(0);
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for 0 int');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for 0 int');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for 0 int');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue([]);
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for empty array');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for empty array');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for empty array');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('abc');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for string');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for string');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for string');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(123);
        $I->assertEquals(123, $I->getProtectedProperty($stub, 'value'), 'check value for 123 int');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for 123 int');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for 123 int');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(['abc']);
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for array');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for array');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for array');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('-1-');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for wrong range');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for wrong range');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for wrong range');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('0 - 2 - 3 - ');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for several ranges');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for several ranges');
        $I->assertEquals(2, $I->getProtectedProperty($stub, 'rangeMax'), 'check rangeMax for several ranges');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('2 - 1');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for incorrect range');
        $I->assertEquals(2, $I->getProtectedProperty($stub, 'rangeMin'), 'check rangeMin for incorrect range');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for incorrect range');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('2 - ');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for correct min range');
        $I->assertEquals(2, $I->getProtectedProperty($stub, 'rangeMin'), 'check rangeMin for correct min range');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMax'), 'check empty rangeMax for correct min range');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue(' - 3');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for correct max range');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'rangeMin'), 'check empty rangeMin for correct max range');
        $I->assertEquals(3, $I->getProtectedProperty($stub, 'rangeMax'), 'check rangeMax for correct max range');

        $stub = StubUtil::makeEmptyExcept(static::CLASS_FULL_NAME, 'setValue');
        $stub->setValue('2 - 3');
        $I->assertEquals(0, $I->getProtectedProperty($stub, 'value'), 'check empty value for correct range');
        $I->assertEquals(2, $I->getProtectedProperty($stub, 'rangeMin'), 'check rangeMin for correct range');
        $I->assertEquals(3, $I->getProtectedProperty($stub, 'rangeMax'), 'check rangeMax for correct range');
    }

}