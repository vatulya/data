<?php

use Codeception\Util\Stub as StubUtil;

class XmlCest
{

    public function testPrepareData(UnitTester $I)
    {
        $stub = StubUtil::makeEmptyExcept('\Model\Data\Source\Xml', 'prepareData');

        $data = false;
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for empty data');

        $data = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Element></Element>
XML;
        $data = new SimpleXMLElement($data);
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);
        $I->assertEquals([], $result, 'check prepareData for wrong data');

        $data = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Items>
    <Item Type="europe">
        <Code>PLN</Code>
        <Value>1.0</Value>
        <Description>zloty polski</Description>
    </Item>
    <Item Type="world">
        <Code>USD</Code>
        <Value>3.33</Value>
        <Description>dolar amerykanski</Description>
    </Item>
</Items>
XML;
        $data = new SimpleXMLElement($data);
        $result = $I->callProtectedMethod($stub, 'prepareData', [$data]);

        $expected = [
            [
                'group' => 'europe',
                'code' => 'PLN',
                'value' => 1.0,
                'name' => 'zloty polski',
            ],
            [
                'group' => 'world',
                'code' => 'USD',
                'value' => 3.33,
                'name' => 'dolar amerykanski',
            ],
        ];
        $I->assertEquals($expected, $result, 'check prepareData for correct data');

    }

}