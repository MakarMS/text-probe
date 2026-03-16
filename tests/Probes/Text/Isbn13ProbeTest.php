<?php

namespace Tests\Probes\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Text\Isbn13Probe;

/**
 * @internal
 */
class Isbn13ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Isbn13Probe();

        $expected = '978-0-306-40615-7';
        $text = 'Value: 978-0-306-40615-7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISBN_13, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Isbn13Probe();

        $expected = '978-0-306-40615-7';
        $text = '978-0-306-40615-7,978-0-306-40615-7';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::ISBN_13, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(35, $results[1]->getEnd());
        $this->assertSame(ProbeType::ISBN_13, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new Isbn13Probe();

        $text = 'Value: 978-0-306-40615-8';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Isbn13Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Isbn13Probe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
