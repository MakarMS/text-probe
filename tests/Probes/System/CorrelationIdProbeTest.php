<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CorrelationIdProbe;

/**
 * @internal
 */
class CorrelationIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CorrelationIdProbe();

        $expected = '9f1d7c1a8b3e4d2f';
        $text = 'Value: 9f1d7c1a8b3e4d2f';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORRELATION_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CorrelationIdProbe();

        $expected = '9f1d7c1a8b3e4d2f';
        $text = 'First 9f1d7c1a8b3e4d2f then 9f1d7c1a8b3e4d2f';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORRELATION_ID, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::CORRELATION_ID, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new CorrelationIdProbe();

        $text = 'Value: corr-id';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CorrelationIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CorrelationIdProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
