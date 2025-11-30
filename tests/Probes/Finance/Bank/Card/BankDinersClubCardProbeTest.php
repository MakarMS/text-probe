<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankDinersClubCardProbe;

/**
 * @internal
 */
class BankDinersClubCardProbeTest extends TestCase
{
    public function testFindsPlainCardNumber(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'My Diners Club card: 30569309025904';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('30569309025904', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(35, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithSpaces(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Diners Club: 38 464089 882389';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('38 464089 882389', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsCardNumberWithDashes(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Card: 38-464089-882389';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('38-464089-882389', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCardNumber(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Invalid Diners Club: 30123456789';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleCardNumbers(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Diners cards: 30075751658960 and 30584241670923';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('30075751658960', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('30584241670923', $results[1]->getResult());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(47, $results[1]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[1]->getProbeType());
    }

    public function testDoesNotCaptureOtherCardSchemes(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Mixed cards: 4111111111111111 and 30569309025904 and 5500000000000004';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('30569309025904', $results[0]->getResult());
        $this->assertEquals(34, $results[0]->getStart());
        $this->assertEquals(48, $results[0]->getEnd());
        $this->assertEquals(ProbeType::BANK_DINERS_CLUB_CARD_NUMBER, $results[0]->getProbeType());
    }

    public function testIgnoresShortNumbers(): void
    {
        $probe = new BankDinersClubCardProbe();

        $text = 'Short: 30569309025';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
