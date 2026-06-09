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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
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
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
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
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::DRIVER_LICENSE, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
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
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
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
