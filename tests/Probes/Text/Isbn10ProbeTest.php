<?php

namespace Tests\Probes\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Text\Isbn10Probe;

/**
 * @internal
 */
class Isbn10ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Isbn10Probe();

        $expected = '0-306-40615-2';
        $text = 'Value: 0-306-40615-2';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISBN_10, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Isbn10Probe();

        $expected = '0-306-40615-2';
        $text = 'First 0-306-40615-2 then 0-306-40615-2';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISBN_10, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::ISBN_10, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new Isbn10Probe();

        $text = 'Value: 0-306-40615-3';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Isbn10Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Isbn10Probe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
