<?php

class CommonCest
{

    public function testCommon(AcceptanceTester $I)
    {
        $I->wantTo('check filters form on webpage');
        $I->amOnPage('/');
//        $I->fillField('source', 'JSON');
//        $I->fillField('source', 'PHP');
//        $I->fillField('source', 'XML');
        $I->fillField('filter[code]', 'XML');
    }

}