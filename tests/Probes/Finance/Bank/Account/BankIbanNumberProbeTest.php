<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\BankIbanNumberProbe;

/**
 * @internal
 */
class BankIbanNumberProbeTest extends TestCase
{
    public function testFindsValidIban(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'My IBAN: DE89370400440532013000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('DE89370400440532013000', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_IBAN_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsIbanWithSpaces(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'IBAN with spaces: DE89 3704 0044 0532 0130 00';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('DE89 3704 0044 0532 0130 00', $results[0]->getResult());
        $this->assertEquals(18, $results[0]->getStart());
        $this->assertEquals(45, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_IBAN_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsLowercaseIban(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'lowercase iban: de89370400440532013000';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('de89370400440532013000', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(38, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_IBAN_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidIban(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'Invalid IBAN: DE8937040044053201300';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleIbans(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'Multiple IBANs: DE89370400440532013000 FR1420041010050500013M02606';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('DE89370400440532013000', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(38, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_IBAN_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('FR1420041010050500013M02606', $results[1]->getResult());
        $this->assertEquals(39, $results[1]->getStart());
        $this->assertEquals(66, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_IBAN_NUMBER, $results[1]->getProbeType());
    }

    public function testIgnoresNonIbanText(): void
    {
        $probe = new BankIbanNumberProbe();

        $text = 'This is just random text without IBAN numbers.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
