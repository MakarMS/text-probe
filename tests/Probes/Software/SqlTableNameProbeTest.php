<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\SqlTableNameProbe;

/**
 * @internal
 */
class SqlTableNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SqlTableNameProbe();

        $expected = 'SELECT * FROM users';
        $text = 'Value: SELECT * FROM users';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::SQL_TABLE_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SqlTableNameProbe();

        $expected = 'SELECT * FROM users';
        $text = 'First SELECT * FROM users then SELECT * FROM users';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::SQL_TABLE_NAME, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(31, $results[1]->getStart());
        $this->assertSame(50, $results[1]->getEnd());
        $this->assertSame(ProbeType::SQL_TABLE_NAME, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SqlTableNameProbe();

        $text = 'Value: SELECT * users';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SqlTableNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SqlTableNameProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
