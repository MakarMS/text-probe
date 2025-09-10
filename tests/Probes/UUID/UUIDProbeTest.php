<?php

namespace Tests\Probes\UUID;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\UUID\UUIDProbe;

class UUIDProbeTest extends TestCase
{
    public function testFindsAllUUIDVersions(): void
    {
        $probe = new UUIDProbe();

        $text = "
            v1: f47ac10b-58cc-11e4-8a5c-0002a5d5c51b
            v2: f47ac10b-58cc-21e4-8a5c-0002a5d5c51b
            v3: f47ac10b-58cc-31e4-8a5c-0002a5d5c51b
            v4: f47ac10b-58cc-41e4-8a5c-0002a5d5c51b
            v5: f47ac10b-58cc-51e4-8a5c-0002a5d5c51b
            v6: f47ac10b-58cc-61e4-8a5c-0002a5d5c51b
        ";

        $results = $probe->probe($text);

        $this->assertCount(6, $results);

        $expectedUUIDs = [
            'f47ac10b-58cc-11e4-8a5c-0002a5d5c51b' => ['start' => 17, 'end' => 53],
            'f47ac10b-58cc-21e4-8a5c-0002a5d5c51b' => ['start' => 70, 'end' => 106],
            'f47ac10b-58cc-31e4-8a5c-0002a5d5c51b' => ['start' => 123, 'end' => 159],
            'f47ac10b-58cc-41e4-8a5c-0002a5d5c51b' => ['start' => 176, 'end' => 212],
            'f47ac10b-58cc-51e4-8a5c-0002a5d5c51b' => ['start' => 229, 'end' => 265],
            'f47ac10b-58cc-61e4-8a5c-0002a5d5c51b' => ['start' => 282, 'end' => 318],
        ];

        foreach ($results as $i => $result) {
            $this->assertEquals(array_keys($expectedUUIDs)[$i], $result->getResult());
            $this->assertEquals($expectedUUIDs[$result->getResult()]['start'], $result->getStart());
            $this->assertEquals($expectedUUIDs[$result->getResult()]['end'], $result->getEnd());
            $this->assertEquals(ProbeType::UUID, $result->getProbeType());
        }
    }

    public function testIgnoresInvalidUUIDs(): void
    {
        $probe = new UUIDProbe();

        $text = "
            Invalid UUIDs:
            short: f47ac10b-58cc-41e4-8a5c-0002a5d5c51
            wrong char: f47ac10b-58cc-41g4-8a5c-0002a5d5c51b
            no dashes: 6f47ac10b58cc41e48a5c0002a5d5c51b
        ";

        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesUUIDsWithUppercaseLetters(): void
    {
        $probe = new UUIDProbe();

        $text = "Uppercase UUID: F47AC10B-58CC-41E4-8A5C-0002A5D5C51B";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('F47AC10B-58CC-41E4-8A5C-0002A5D5C51B', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(52, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[0]->getProbeType());

    }

    public function testMatchesMultipleUUIDsInOneLine(): void
    {
        $probe = new UUIDProbe();

        $text = "v4: f47ac10b-58cc-41e4-8a5c-0002a5d5c51b, v5: f47ac10b-58cc-51e4-8a5c-0002a5d5c51b; v6: f47ac10b-58cc-61e4-8a5c-0002a5d5c51b.";
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('f47ac10b-58cc-41e4-8a5c-0002a5d5c51b', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(40, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[0]->getProbeType());

        $this->assertEquals('f47ac10b-58cc-51e4-8a5c-0002a5d5c51b', $results[1]->getResult());
        $this->assertEquals(46, $results[1]->getStart());
        $this->assertEquals(82, $results[1]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[1]->getProbeType());

        $this->assertEquals('f47ac10b-58cc-61e4-8a5c-0002a5d5c51b', $results[2]->getResult());
        $this->assertEquals(88, $results[2]->getStart());
        $this->assertEquals(124, $results[2]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[2]->getProbeType());

    }

    public function testUUIDsNextToPunctuation(): void
    {
        $probe = new UUIDProbe();

        $text = "Check UUID: (f47ac10b-58cc-41e4-8a5c-0002a5d5c51b). Another: [f47ac10b-58cc-51e4-8a5c-0002a5d5c51b]!";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('f47ac10b-58cc-41e4-8a5c-0002a5d5c51b', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(49, $results[0]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[0]->getProbeType());

        $this->assertEquals('f47ac10b-58cc-51e4-8a5c-0002a5d5c51b', $results[1]->getResult());
        $this->assertEquals(62, $results[1]->getStart());
        $this->assertEquals(98, $results[1]->getEnd());
        $this->assertEquals(ProbeType::UUID, $results[1]->getProbeType());

    }
}
