<?php

use Codeception\Util\Stub as StubUtil;

class AbstractSourceCest
{

    public function testConstructor(UnitTester $I)
    {
        $config = ['key' => 'value', 'key2' => 'value2'];
        $stub = StubUtil::construct('\Dummy\Model\Data\Source\AbstractSource', [$config]);
        $I->assertNotEmpty($I->getProtectedProperty($stub, 'config'), 'check if constructor write config');
        $I->assertEquals($config, $I->getProtectedProperty($stub, 'config'), 'check if constructor write correct array config');
    }

    public function testConstructorForEmptyConfig(UnitTester $I)
    {
        $stub = StubUtil::construct('\Dummy\Model\Data\Source\AbstractSource', []);
        $I->assertEmpty($I->getProtectedProperty($stub, 'config'), 'check if constructor write empty config');
        $I->assertEquals([], $I->getProtectedProperty($stub, 'config'), 'check if constructor write empty array config');
    }

}