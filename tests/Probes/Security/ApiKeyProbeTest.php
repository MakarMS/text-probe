<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\ApiKeyProbe;

/**
 * @internal
 */
class ApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Value: sk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'Value: AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ApiKeyProbe();

        $expectedFirst = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'AKIA1234567890ABCDEF';
        $text = 'First sk_test_abcdefghijklmnopqrstuvwxyz then AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(46, $results[1]->getStart());
        $this->assertSame(66, $results[1]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'sk_test_abcdefghijklmnopqrstuvwxyz tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'head sk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Check sk_test_abcdefghijklmnopqrstuvwxyz, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new ApiKeyProbe();

        $expectedFirst = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'sk_test_abcdefghijklmnopqrstuvwxyz and sk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(39, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'AKIA1234567890ABCDEF';
        $text = 'Prefix AKIA1234567890ABCDEF suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new ApiKeyProbe();

        $expectedFirst = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $expectedSecond = 'AKIA1234567890ABCDEF';
        $text = 'sk_test_abcdefghijklmnopqrstuvwxyz, AKIA1234567890ABCDEF';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(34, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(36, $results[1]->getStart());
        $this->assertSame(56, $results[1]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new ApiKeyProbe();

        $expected = 'sk_test_abcdefghijklmnopqrstuvwxyz';
        $text = 'Value: sk_test_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::API_KEY, $results[0]->getProbeType());
    }
}
