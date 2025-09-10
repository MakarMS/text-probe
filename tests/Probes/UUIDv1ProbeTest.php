<?php

namespace Tests\Probes;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\UUIDv1Probe;

class UUIDv1ProbeTest extends TestCase
{
    public function testFindsSingleUUIDv1(): void
    {
        $probe = new UUIDv1Probe();

        $text = "v1 UUID: f47ac10b-58cc-11e4-8a5c-0002a5d5c51b";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('f47ac10b-58cc-11e4-8a5c-0002a5d5c51b', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(45, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[0]->getProbeType());
    }

    public function testIgnoresOtherUUIDVersions(): void
    {
        $probe = new UUIDv1Probe();

        $text = "v2: f47ac10b-58cc-21e4-8a5c-0002a5d5c51b v3: f47ac10b-58cc-31e4-8a5c-0002a5d5c51b v4: f47ac10b-58cc-41e4-8a5c-0002a5d5c51b";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleUUIDv1(): void
    {
        $probe = new UUIDv1Probe();

        $text = "First: f47ac10b-58cc-11e4-8a5c-0002a5d5c51b, Second: f47ac10b-1234-11e4-aaaa-0002a5d5c51b";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('f47ac10b-58cc-11e4-8a5c-0002a5d5c51b', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(43, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[0]->getProbeType());

        $this->assertEquals('f47ac10b-1234-11e4-aaaa-0002a5d5c51b', $results[1]->getResult());
        $this->assertEquals(53, $results[1]->getStart());
        $this->assertEquals(89, $results[1]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[1]->getProbeType());
    }

    public function testMatchesUppercaseUUIDv1(): void
    {
        $probe = new UUIDv1Probe();

        $text = "Uppercase UUID: F47AC10B-58CC-11E4-8A5C-0002A5D5C51B";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('F47AC10B-58CC-11E4-8A5C-0002A5D5C51B', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(52, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[0]->getProbeType());
    }

    public function testUUIDv1NextToPunctuation(): void
    {
        $probe = new UUIDv1Probe();

        $text = "(f47ac10b-58cc-11e4-8a5c-0002a5d5c51b). [f47ac10b-1234-11e4-aaaa-0002a5d5c51b]!";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('f47ac10b-58cc-11e4-8a5c-0002a5d5c51b', $results[0]->getResult());
        $this->assertEquals(1, $results[0]->getStart());
        $this->assertEquals(37, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[0]->getProbeType());


        $this->assertEquals('f47ac10b-1234-11e4-aaaa-0002a5d5c51b', $results[1]->getResult());
        $this->assertEquals(41, $results[1]->getStart());
        $this->assertEquals(77, $results[1]->getEnd());
        $this->assertEquals(ProbeType::UUIDv1, $results[1]->getProbeType());

    }

    public function testInvalidUUIDsAreIgnored(): void
    {
        $probe = new UUIDv1Probe();

        $text = "short: f47ac10b-58cc-11e4-8a5c-0002a5d5c51 wrong char: f47ac10b-58cc-11g4-8a5c-0002a5d5c51b no dashes: f47ac10b58cc11e48a5c0002a5d5c51b";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}