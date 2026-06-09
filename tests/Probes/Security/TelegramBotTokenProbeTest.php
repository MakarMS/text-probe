<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\TelegramBotTokenProbe;

/**
 * @internal
 */
class TelegramBotTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '9876543210:abcdefghijklmnopqrstuvwxyzABCDE_12345';
        $text = '9876543210:abcdefghijklmnopqrstuvwxyzABCDE_12345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(48, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TelegramBotTokenProbe();

        $first = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $second = '9876543210:abcdefghijklmnopqrstuvwxyzABCDE_12345';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234' . "\n" . '9876543210:abcdefghijklmnopqrstuvwxyzABCDE_12345';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(47, $results[1]->getStart());
        $this->assertSame(95, $results[1]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new TelegramBotTokenProbe();

        $text = '12345:short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TelegramBotTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TelegramBotTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new TelegramBotTokenProbe();

        $expected = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $text = '123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::TELEGRAM_BOT_TOKEN, $results[0]->getProbeType());
    }
}
