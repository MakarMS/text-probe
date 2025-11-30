<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankMirCardProbe;

/**
 * @internal
 */
class BankMirCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'My Mir card: 2202018221284841';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2202018221284841', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Mir: 2200 5168 8733 1568';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2200 5168 8733 1568', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Card: 2201-2622-6018-7462';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2201-2622-6018-7462', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Invalid Mir: 2200123456789011';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Mir cards: 2203884600821696 and 2204014351265708';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('2203884600821696', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('2204014351265708', $results[1]->getResult());
        $this->assertEquals(32, $results[1]->getStart());
        $this->assertEquals(48, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Mixed cards: 4111111111111111 and 2202018221284841 and 5555555555554444';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2202018221284841', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_MIR_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankMirCardProbe();

        $text = 'Short: 2200123456789';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
