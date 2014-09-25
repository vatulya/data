<?php

use Codeception\Util\Stub as StubUtil;

class AbstractFilterCest
{

    public function testSetValue(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept('\Model\Data\Filter\AbstractFilter', 'setValue');

        $value = 'some value';
        $result = $stub->setValue($value);
        $I->assertNotEmpty($I->getProtectedProperty($stub, 'value'), 'check if constructor write value');
        $I->assertEquals($value, $I->getProtectedProperty($stub, 'value'), 'check if constructor write correct value');

        $I->assertEquals($stub, $result, 'check if setValue returns $this');

        $value = 'some new value';
        $stub->setValue($value);
        $I->assertNotEmpty($I->getProtectedProperty($stub, 'value'), 'check if constructor rewrite value');
        $I->assertEquals($value, $I->getProtectedProperty($stub, 'value'), 'check if constructor rewrite correct value');
    }

}