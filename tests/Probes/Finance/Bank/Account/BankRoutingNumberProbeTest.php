<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\BankRoutingNumberProbe;

class BankRoutingNumberProbeTest extends TestCase
{
    public function testFindsValidRoutingNumber(): void
    {
        $probe = new BankRoutingNumberProbe();

        $text = "Valid routing number: 011000015";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('011000015', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_ROUTING_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidLength(): void
    {
        $probe = new BankRoutingNumberProbe();

        $text = "Too short: 12345678";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);

        $text = "Too long: 1234567890";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleRoutingNumbers(): void
    {
        $probe = new BankRoutingNumberProbe();

        $text = "Multiple routing numbers: 011000015 and 021000021";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('011000015', $results[0]->getResult());
        $this->assertEquals(26, $results[0]->getStart());
        $this->assertEquals(35, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_ROUTING_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('021000021', $results[1]->getResult());
        $this->assertEquals(40, $results[1]->getStart());
        $this->assertEquals(49, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_ROUTING_NUMBER, $results[1]->getProbeType());
    }

    public function testIgnoresNonDigits(): void
    {
        $probe = new BankRoutingNumberProbe();

        $text = "Invalid: ABCDEFGHI";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testEmptyStringIsInvalid(): void
    {
        $probe = new BankRoutingNumberProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testStringWithSpacesOnlyIsInvalid(): void
    {
        $probe = new BankRoutingNumberProbe();

        $results = $probe->probe('     ');

        $this->assertCount(0, $results);
    }
}
