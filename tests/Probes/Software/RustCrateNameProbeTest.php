<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\RustCrateNameProbe;

/**
 * @internal
 */
class RustCrateNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RustCrateNameProbe();

        $expected = 'serde_json';
        $text = 'Value: serde_json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUST_CRATE_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RustCrateNameProbe();

        $expected = 'serde_json';
        $text = 'serde_json,serde_json';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::RUST_CRATE_NAME, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(21, $results[1]->getEnd());
        $this->assertSame(ProbeType::RUST_CRATE_NAME, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new RustCrateNameProbe();

        $text = 'Value: Serde-Json';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new RustCrateNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new RustCrateNameProbe();

        $results = $probe->probe('UPPERCASE_ONLY __ ---');

        $this->assertCount(0, $results);
    }
}
