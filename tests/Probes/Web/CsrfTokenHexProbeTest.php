<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CsrfTokenHexProbe;

/**
 * @internal
 */
class CsrfTokenHexProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Value: 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = 'abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $text = 'Value: abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = 'abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $text = 'First 0123456789abcdef0123456789abcdef then abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(92, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'head 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Check 0123456789abcdef0123456789abcdef, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = '0123456789abcdef0123456789abcdef';
        $text = '0123456789abcdef0123456789abcdef and 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(69, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = 'abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $text = 'Prefix abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expectedFirst = '0123456789abcdef0123456789abcdef';
        $expectedSecond = 'abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $text = '0123456789abcdef0123456789abcdef, abcdefabcdefabcdefabcdefabcdefabcdefabcdefabcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(34, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new CsrfTokenHexProbe();

        $expected = '0123456789abcdef0123456789abcdef';
        $text = 'Value: 0123456789abcdef0123456789abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSRF_TOKEN_HEX, $results[0]->getProbeType());
    }
}
