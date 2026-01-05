<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\AwsAccessKeyIdProbe;

/**
 * @internal
 */
class AwsAccessKeyIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'Value: AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'ASIAABCDEFGHIJKLMNOP';
        $text = 'Value: ASIAABCDEFGHIJKLMNOP';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expectedFirst = 'AKIA1234567890ABCDEF';
        $expectedSecond = 'ASIAABCDEFGHIJKLMNOP';
        $text = 'First AKIA1234567890ABCDEF then ASIAABCDEFGHIJKLMNOP';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(52, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'AKIA1234567890ABCDEF tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'head AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'Check AKIA1234567890ABCDEF, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expectedFirst = 'AKIA1234567890ABCDEF';
        $expectedSecond = 'AKIA1234567890ABCDEF';
        $text = 'AKIA1234567890ABCDEF and AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(45, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'ASIAABCDEFGHIJKLMNOP';
        $text = 'Prefix ASIAABCDEFGHIJKLMNOP suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expectedFirst = 'AKIA1234567890ABCDEF';
        $expectedSecond = 'ASIAABCDEFGHIJKLMNOP';
        $text = 'AKIA1234567890ABCDEF, ASIAABCDEFGHIJKLMNOP';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(42, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new AwsAccessKeyIdProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'Value: AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ACCESS_KEY_ID, $results[0]->getProbeType());
    }
}
