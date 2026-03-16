<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\RedisConnectionStringProbe;

/**
 * @internal
 */
class RedisConnectionStringProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RedisConnectionStringProbe();

        $expected = 'redis://:pass@localhost:6379/0';
        $text = 'Value: redis://:pass@localhost:6379/0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::REDIS_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RedisConnectionStringProbe();

        $expected = 'redis://:pass@localhost:6379/0';
        $text = 'First redis://:pass@localhost:6379/0 then redis://:pass@localhost:6379/0';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::REDIS_CONNECTION_STRING, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(72, $results[1]->getEnd());
        $this->assertSame(ProbeType::REDIS_CONNECTION_STRING, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new RedisConnectionStringProbe();

        $text = 'Value: rd://localhost';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new RedisConnectionStringProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new RedisConnectionStringProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
