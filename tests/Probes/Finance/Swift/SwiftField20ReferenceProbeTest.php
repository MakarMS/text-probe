<?php

namespace Tests\Probes\Finance\Swift;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Swift\SwiftField20ReferenceProbe;

/**
 * @internal
 */
class SwiftField20ReferenceProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'REF/ABC12';
        $text = 'Value: REF/ABC12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'ABCDEF12-34';
        $text = 'Value: ABCDEF12-34';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expectedFirst = 'REF/ABC12';
        $expectedSecond = 'ABCDEF12-34';
        $text = 'First REF/ABC12 then ABCDEF12-34';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'REF/ABC12';
        $text = 'REF/ABC12 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'REF/ABC12';
        $text = 'head REF/ABC12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'REF/ABC12';
        $text = 'Check REF/ABC12, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expectedFirst = 'REF/ABC12';
        $expectedSecond = 'REF/ABC12';
        $text = 'REF/ABC12 and REF/ABC12';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(23, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'ABCDEF12-34';
        $text = 'Prefix ABCDEF12-34 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expectedFirst = 'REF/ABC12';
        $expectedSecond = 'ABCDEF12-34';
        $text = 'REF/ABC12, ABCDEF12-34';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SwiftField20ReferenceProbe();

        $expected = 'REF/ABC12';
        $text = 'Value: REF/ABC12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::SWIFT_FIELD20_REFERENCE, $results[0]->getProbeType());
    }
}
