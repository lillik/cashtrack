<?php
$I = new WebGuy($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/');
$I->see('Cashflow');
$I->see('Reports');
