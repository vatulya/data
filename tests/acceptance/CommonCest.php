<?php

class CommonCest
{

    public function testCommon(AcceptanceTester $I)
    {
        $I->wantTo('check filters form on webpage');
        $I->amOnPage('/');
        $I->selectOption('source', 'JSON');
        $I->fillField('filter[code]', 'USD');
        $I->fillField('filter[group]', 'world');
        $I->fillField('filter[name]', 'dolar');
        $I->fillField('filter[value-range-min]', '1');
        $I->fillField('filter[value-range-max]', '10');
        $I->click('Submit');
    }

    public function testGetData(AcceptanceTester $I)
    {
        $I->wantTo('check ajax load data');
        $I->sendAjaxGetRequest('/?action=data');
        $I->see('id="data-table"');
    }

}