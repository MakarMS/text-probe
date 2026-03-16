<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CronExpressionProbe;

/**
 * @internal
 */
class CronExpressionProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CronExpressionProbe();

        $expected = '*/5 0 1 1 *';
        $text = 'Value: */5 0 1 1 *';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRON_EXPRESSION, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CronExpressionProbe();

        $expected = '*/5 0 1 1 *';
        $text = 'First */5 0 1 1 * then */5 0 1 1 *';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::CRON_EXPRESSION, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::CRON_EXPRESSION, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new CronExpressionProbe();

        $text = 'Value: 60 24 32 13 7';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CronExpressionProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CronExpressionProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
