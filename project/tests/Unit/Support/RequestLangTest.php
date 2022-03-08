<?php

namespace Tests\Unit\Support;

use App\Support\RequestLang;
use Tests\Cases\TestCaseWithoutFramework;

class RequestLangTest extends TestCaseWithoutFramework
{
    public function testGetNoLocaleWhenHeaderIsEmpty()
    {
        $langHeader = '';
        $this->assertEquals('', RequestLang::getLocaleByHttpAcceptHeader($langHeader));
    }

    public function testGetDefinedLocaleWhenItsFirst()
    {
        $langHeader = 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
        $this->assertEquals('pt_BR', RequestLang::getLocaleByHttpAcceptHeader($langHeader));
    }

    public function testGetDefinedLocaleWhenItsNotFirst()
    {
        $langHeader = 'pt;q=0.9,en-US;q=0.8,en;q=0.7,pt-BR';
        $this->assertEquals('pt_BR', RequestLang::getLocaleByHttpAcceptHeader($langHeader));
    }

    public function testGetMostProbablyLocaleWhenDefaultNotSpecified()
    {
        $langHeader = 'pt;q=0.6,en-US;q=0.8,en;q=0.7';
        $this->assertEquals('en_US', RequestLang::getLocaleByHttpAcceptHeader($langHeader));
    }
}
