<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SentryEventIdProbe;

/**
 * @internal
 */
class SentryEventIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = 'abcdefabcdefabcdefabcdefabcdefab';
        $text = 'abcdefabcdefabcdefabcdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SentryEventIdProbe();

        $first = '0123456789abcdef0123456789abcdef';
        $second = 'abcdefabcdefabcdefabcdefabcdefab';
        $text = '0123456789abcdef0123456789abcdef' . "\n" . 'abcdefabcdefabcdefabcdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(33, $results[1]->getStart());
        $this->assertSame(65, $results[1]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new SentryEventIdProbe();

        $text = 'sentry-event-id';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SentryEventIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SentryEventIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new SentryEventIdProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_EVENT_ID, $results[0]->getProbeType());
    }
}
