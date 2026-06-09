<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\DiscordBotTokenProbe;

/**
 * @internal
 */
class DiscordBotTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'mfa.abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'mfa.abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DiscordBotTokenProbe();

        $first = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $second = 'mfa.abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456' . "\n" . 'mfa.abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(67, $results[1]->getStart());
        $this->assertSame(107, $results[1]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DiscordBotTokenProbe();

        $text = 'abc.def.short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DiscordBotTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DiscordBotTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DiscordBotTokenProbe();

        $expected = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $text = 'MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::DISCORD_BOT_TOKEN, $results[0]->getProbeType());
    }
}
