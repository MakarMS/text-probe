<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\PostgresConnectionStringProbe;

/**
 * @internal
 */
class PostgresConnectionStringProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PostgresConnectionStringProbe();

        $expected = 'postgres://user:pass@localhost:5432/app';
        $text = 'Value: postgres://user:pass@localhost:5432/app';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::POSTGRES_CONNECTION_STRING, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PostgresConnectionStringProbe();

        $expected = 'postgres://user:pass@localhost:5432/app';
        $text = 'First postgres://user:pass@localhost:5432/app then postgres://user:pass@localhost:5432/app';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::POSTGRES_CONNECTION_STRING, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(51, $results[1]->getStart());
        $this->assertSame(90, $results[1]->getEnd());
        $this->assertSame(ProbeType::POSTGRES_CONNECTION_STRING, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new PostgresConnectionStringProbe();

        $text = 'Value: pg://localhost';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PostgresConnectionStringProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PostgresConnectionStringProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
