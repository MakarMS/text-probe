<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankVisaCardProbe;

/**
 * @internal
 */
class BankVisaCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'My Visa card: 4111111111111111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Visa: 4111 1111 1111 1111';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111 1111 1111 1111', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Card: 4012-8888-8888-1881';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4012-8888-8888-1881', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFinds13DigitVisa(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Visa short: 4222222222222';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4222222222222', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Invalid Visa: 4111111111111112';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Visas: 4111111111111111 and 4012888888881881';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('4012888888881881', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(44, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Mixed cards: 378282246310005 and 4111111111111111 and 5500000000000004';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('4111111111111111', $results[0]->getResult());
        $this->assertEquals(33, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_VISA_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankVisaCardProbe();

        $text = 'Short: 41111';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
