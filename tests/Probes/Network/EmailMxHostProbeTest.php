<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\EmailMxHostProbe;

/**
 * @internal
 */
class EmailMxHostProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'mx1.example.com';
        $text = 'mx1.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'aspmx.l.google.com';
        $text = 'aspmx.l.google.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EmailMxHostProbe();

        $first = 'mx1.example.com';
        $second = 'aspmx.l.google.com';
        $text = 'mx1.example.com' . "\n" . 'aspmx.l.google.com';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'mx1.example.com';
        $text = 'mx1.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'mx1.example.com';
        $text = 'mx1.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'mx1.example.com';
        $text = 'mx1.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new EmailMxHostProbe();

        $text = 'example.com';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new EmailMxHostProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new EmailMxHostProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new EmailMxHostProbe();

        $expected = 'mx1.example.com';
        $text = 'mx1.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_MX_HOST, $results[0]->getProbeType());
    }
}
