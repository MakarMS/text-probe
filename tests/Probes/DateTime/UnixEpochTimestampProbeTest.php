<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\UnixEpochTimestampProbe;

/**
 * @internal
 */
class UnixEpochTimestampProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new UnixEpochTimestampProbe();

        $expected = '1710567890';
        $text = 'Value: 1710567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::UNIX_EPOCH_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new UnixEpochTimestampProbe();

        $expected = '1710567890';
        $text = 'First 1710567890 then 1710567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::UNIX_EPOCH_TIMESTAMP, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::UNIX_EPOCH_TIMESTAMP, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new UnixEpochTimestampProbe();

        $text = 'Value: 171056789';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new UnixEpochTimestampProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new UnixEpochTimestampProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
