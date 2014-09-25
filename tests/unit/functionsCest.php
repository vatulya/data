<?php

require_once APPLICATION_PATH . 'functions.php';

class FunctionsCest
{

    public function testGetArrayValue(UnitTester $I)
    {
        $array = [
            'key' => 'value',
        ];
        $I->assertEquals('value', getArrayValue($array, 'key'), 'check if getArrayValue returns correct data');

        $array = [
            'key' => 'value',
        ];
        $I->assertEquals('defaultValue', getArrayValue($array, 'wrongKey', 'defaultValue'), 'check if getArrayValue returns correct default data');

        $array = 'wrong array type';
        $I->assertEquals('defaultValue', getArrayValue($array, 'key', 'defaultValue'), 'check if getArrayValue returns correct default data when wrong type');

        $array = [];
        $I->assertEquals(null, getArrayValue($array, 'key'), 'check if getArrayValue returns null for empty array');
    }

}