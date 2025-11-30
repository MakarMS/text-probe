<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankRupayCardProbe;

/**
 * @internal
 */
class BankRupayCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'My RuPay card: 6023540132499349';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6023540132499349', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(31, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'RuPay: 5081 8165 5773 2146';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('5081 8165 5773 2146', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'Card: 6023-5401-3249-9349';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6023-5401-3249-9349', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'Invalid RuPay: 6023540132499340';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'RuPay cards: 6023540132499349 and 5081816557732146';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('6023540132499349', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('5081816557732146', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(50, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'Mixed cards: 4111111111111111 and 6023540132499349 and 5555555555554444';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('6023540132499349', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_RUPAY_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankRupayCardProbe();

        $text = 'Short: 6081251234567';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
