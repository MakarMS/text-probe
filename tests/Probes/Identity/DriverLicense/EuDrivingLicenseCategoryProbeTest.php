<?php

namespace Tests\Probes\Identity\DriverLicense;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\DriverLicense\EuDrivingLicenseCategoryProbe;

/**
 * @internal
 */
class EuDrivingLicenseCategoryProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EuDrivingLicenseCategoryProbe();

        $expected = 'C1E';
        $text = 'Value: C1E';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::EU_DRIVING_LICENSE_CATEGORY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EuDrivingLicenseCategoryProbe();

        $expected = 'C1E';
        $text = 'First C1E then C1E';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::EU_DRIVING_LICENSE_CATEGORY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(18, $results[1]->getEnd());
        $this->assertSame(ProbeType::EU_DRIVING_LICENSE_CATEGORY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new EuDrivingLicenseCategoryProbe();

        $text = 'Value: ZZ';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new EuDrivingLicenseCategoryProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new EuDrivingLicenseCategoryProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
