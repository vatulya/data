<?php

use Codeception\Util\Stub as StubUtil;

class ManagerCest
{

    /**
     * @var \Model\Data\Manager
     */
    protected $_stub;

    public function _before()
    {
        $this->_stub = StubUtil::make('\Model\Data\Manager');
    }

    public function _after()
    {
        unset($this->_stub);
    }

    public function testAddFilter(UnitTester $I)
    {
        $I->assertEmpty($I->getProtectedProperty($this->_stub, 'filters'), 'check if new Manager has empty filters');

        $abstractFilterStub = StubUtil::makeEmpty('\Model\Data\Filter\AbstractFilter');
        $this->_stub->addFilter($abstractFilterStub);
        $I->assertNotEmpty($I->getProtectedProperty($this->_stub, 'filters'), 'check if new Manager added filter');
        $I->assertEquals(1, count($I->getProtectedProperty($this->_stub, 'filters')), 'check if Manager added only filter');

        $this->_stub->addFilter($abstractFilterStub);
        $I->assertEquals(2, count($I->getProtectedProperty($this->_stub, 'filters')), 'check if Manager added another one filter');
        $expected = [$abstractFilterStub, $abstractFilterStub];
        $I->assertEquals($expected, $I->getProtectedProperty($this->_stub, 'filters'), 'check if Manager contain correct property filter');
    }

    public function testApplyFilters(UnitTester $I)
    {
        $I->assertEmpty($I->getProtectedProperty($this->_stub, 'filters'), 'check if new Manager has empty filters');

        $data = ['one', 'two', 'three', 'four', 'five', 'six'];
        $result = $I->callProtectedMethod($this->_stub, 'applyFilters', [$data]);
        $I->assertEquals($data, $result, 'check if applyFilters doing nothing without filters');

        $abstractFilterStub = StubUtil::makeEmpty('\Model\Data\Filter\AbstractFilter', [
            'filter' => function (array $data) {
                    array_pop($data);
                    return $data;
                }
        ]);
        $this->_stub->addFilter($abstractFilterStub);
        $this->_stub->addFilter($abstractFilterStub);
        $expected = ['one', 'two', 'three', 'four'];
        $result = $I->callProtectedMethod($this->_stub, 'applyFilters', [$data]);
        $I->assertEquals($expected, $result, 'check if applyFilters works correctly');

        $abstractFilterStub = StubUtil::makeEmpty('\Model\Data\Filter\AbstractFilter', [
            'filter' => function () {
                    throw new \Exception('test exception');
                }
        ]);
        $this->_stub->addFilter($abstractFilterStub);
        $expected = ['one', 'two', 'three', 'four'];
        $result = $I->callProtectedMethod($this->_stub, 'applyFilters', [$data]);
        $I->assertEquals($expected, $result, 'check if applyFilters works correctly with broken some filter');
    }

    public function testApplyOrder(UnitTester $I)
    {
        $data = [
            ['id' => 1, 'a' => 1, 'b' => 1, 'c' => 'd'],
            ['id' => 2, 'a' => 4, 'b' => 1, 'c' => 'a'],
            ['id' => 3, 'a' => 1, 'b' => 1, 'c' => 'c'],
            ['id' => 4, 'a' => 3, 'b' => 1, 'c' => 'b'],
        ];
        $result = $I->callProtectedMethod($this->_stub, 'applyOrder', [$data, null, null]);
        $I->assertEquals($data, $result, 'check if no order');

        $result = $I->callProtectedMethod($this->_stub, 'applyOrder', [$data, 'a', null]);
        $expected = [
            ['id' => 3, 'a' => 1, 'b' => 1, 'c' => 'c'],
            ['id' => 1, 'a' => 1, 'b' => 1, 'c' => 'd'],
            ['id' => 4, 'a' => 3, 'b' => 1, 'c' => 'b'],
            ['id' => 2, 'a' => 4, 'b' => 1, 'c' => 'a'],
        ];
        $I->assertEquals($expected, $result, 'check if sorting is correct');

        $result = $I->callProtectedMethod($this->_stub, 'applyOrder', [$data, 'c', 'desc']);
        $expected = [
            ['id' => 1, 'a' => 1, 'b' => 1, 'c' => 'd'],
            ['id' => 3, 'a' => 1, 'b' => 1, 'c' => 'c'],
            ['id' => 4, 'a' => 3, 'b' => 1, 'c' => 'b'],
            ['id' => 2, 'a' => 4, 'b' => 1, 'c' => 'a'],
        ];
        $I->assertEquals($expected, $result, 'check if sorting is correct for string and desc direction');

    }

}