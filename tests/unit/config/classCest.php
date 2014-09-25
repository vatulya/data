<?php

use Codeception\Util\Stub as StubUtil;

require_once APPLICATION_PATH . 'config/class.php';

class ConfigCest
{

    /**
     * @var Config
     */
    protected $_stub;

    public function _before()
    {
        $this->_stub = StubUtil::make('Config');
    }

    public function _after()
    {
        unset($this->_stub);
    }

    public function testLoad(UnitTester $I)
    {
        $config = ['some data', 'some data 2'];
        $this->_stub->load($config);
        $I->assertEquals($config, $I->getProtectedProperty($this->_stub, 'config'), 'check if config array loaded correctly');

        $I->assertTrue(
            $I->seeExceptionThrown('Exception', function() {
                $this->_stub->load(['try to rewrite config']);
            })
            , 'check if Config throws exception on rewrite config'
        );
    }

}