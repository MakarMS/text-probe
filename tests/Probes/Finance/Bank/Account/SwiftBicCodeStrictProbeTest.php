<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\SwiftBicCodeStrictProbe;

/**
 * @internal
 */
class SwiftBicCodeStrictProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SwiftBicCodeStrictProbe();

        $expected = 'DEUTDEFF500';
        $text = 'Value: DEUTDEFF500';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_BIC_CODE_STRICT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SwiftBicCodeStrictProbe();

        $expected = 'DEUTDEFF500';
        $text = 'First DEUTDEFF500 then DEUTDEFF500';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_BIC_CODE_STRICT, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_BIC_CODE_STRICT, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SwiftBicCodeStrictProbe();

        $text = 'Value: DEUTD';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SwiftBicCodeStrictProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SwiftBicCodeStrictProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
