<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankVerveCardProbe;

class BankVerveCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "My Verve card: 5060771326392463";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('5060771326392463', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Verve: 5061 1412 6412 6928";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('5061 1412 6412 6928', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Card: 6500-0052-5264-4134";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6500-0052-5264-4134', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Invalid Verve: 5060771326392462";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Verve cards: 6500005252644134 and 6501216683377447";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('6500005252644134', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('6501216683377447', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(50, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Mixed cards: 4111111111111111 and 5060771326392463 and 5555555555554444";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('5060771326392463', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VERVE_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankVerveCardProbe();

        $text = "Short: 50607713263";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
