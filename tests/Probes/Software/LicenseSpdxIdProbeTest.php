<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\LicenseSpdxIdProbe;

/**
 * @internal
 */
class LicenseSpdxIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LicenseSpdxIdProbe();

        $expected = 'Apache-2.0';
        $text = 'Value: Apache-2.0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::LICENSE_SPDX_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LicenseSpdxIdProbe();

        $expected = 'Apache-2.0';
        $text = 'First Apache-2.0 then Apache-2.0';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::LICENSE_SPDX_ID, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::LICENSE_SPDX_ID, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new LicenseSpdxIdProbe();

        $text = 'Value: Apache2';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new LicenseSpdxIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new LicenseSpdxIdProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
