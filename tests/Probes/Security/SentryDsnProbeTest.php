<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SentryDsnProbe;

/**
 * @internal
 */
class SentryDsnProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SentryDsnProbe();

        $expected = 'https://abcdef123456@example.ingest.sentry.io/12345';
        $text = 'Value: https://abcdef123456@example.ingest.sentry.io/12345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(58, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_DSN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SentryDsnProbe();

        $expected = 'https://abcdef123456@example.ingest.sentry.io/12345';
        $text = 'First https://abcdef123456@example.ingest.sentry.io/12345 then https://abcdef123456@example.ingest.sentry.io/12345';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(57, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENTRY_DSN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(63, $results[1]->getStart());
        $this->assertSame(114, $results[1]->getEnd());
        $this->assertSame(ProbeType::SENTRY_DSN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SentryDsnProbe();

        $text = 'Value: sentry://dsn';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SentryDsnProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SentryDsnProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
