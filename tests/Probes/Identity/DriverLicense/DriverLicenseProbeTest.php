<?php

namespace Tests\Probes\Identity\DriverLicense;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\DriverLicense\DriverLicenseProbe;

/**
 * @internal
 */
class DriverLicenseProbeTest extends TestCase
{
    public function testFindsUkMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = 'ABCD9123456FG7HI';
        $text = "Value:\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Value:\n"), $results[0]->getStart());
        $this->assertSame(strlen("Value:\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsItalianMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = 'AB1234567';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsSpanishMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = '12345678A';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsDutchMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = '1234567890';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsPolishMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = 'ABCDE123456789';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsSwissMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = 'A123456789';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsRussianMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = '12 34 567890';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsUsMatch(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = '9Z8X7C6V5B4N3';
        $text = "Header\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Header\n"), $results[0]->getStart());
        $this->assertSame(strlen("Header\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DriverLicenseProbe();

        $expectedFirst = 'ABCD9123456FG7HI';
        $expectedSecond = 'QWERT1234569Z8YX';
        $text = "First\n" . $expectedFirst . "\nthen\n" . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = strpos($text, $expectedFirst);
        $firstEnd = $firstStart + strlen($expectedFirst);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());

        $secondStart = strpos($text, $expectedSecond, $firstEnd);
        $secondEnd = $secondStart + strlen($expectedSecond);
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[1]->getProbeType());
    }

    public function testPrefersFirstMatchingProbe(): void
    {
        $probe = new DriverLicenseProbe();

        $expected = 'ABCD9123456FG7HI';
        $text = "Start\n" . $expected . "\n" . '9Z8X7C6V5B4N3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strlen("Start\n"), $results[0]->getStart());
        $this->assertSame(strlen("Start\n") + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new DriverLicenseProbe();

        $text = "Invalid\n12345\nTail";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
