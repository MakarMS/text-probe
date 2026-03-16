<?php

namespace Tests\Probes\Finance\Bank\Card;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Card\BankCardMaskedProbe;

/**
 * @internal
 */
class BankCardMaskedProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new BankCardMaskedProbe();

        $expected = '**** **** **** 4242';
        $text = 'Value: **** **** **** 4242';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::BANK_CARD_MASKED, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new BankCardMaskedProbe();

        $expected = '**** **** **** 4242';
        $text = 'First **** **** **** 4242 then **** **** **** 4242';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::BANK_CARD_MASKED, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(31, $results[1]->getStart());
        $this->assertSame(50, $results[1]->getEnd());
        $this->assertSame(ProbeType::BANK_CARD_MASKED, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new BankCardMaskedProbe();

        $text = 'Value: **** **** **** ****';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new BankCardMaskedProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new BankCardMaskedProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
