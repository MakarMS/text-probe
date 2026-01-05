<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\BasicAuthBase64Probe;

/**
 * @internal
 */
class BasicAuthBase64ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'QWxhZGRpbjpvcGVu';
        $text = 'Value: QWxhZGRpbjpvcGVu';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'dXNlcjpwYXNzPT0=';
        $text = 'Value: dXNlcjpwYXNzPT0=';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expectedFirst = 'QWxhZGRpbjpvcGVu';
        $expectedSecond = 'dXNlcjpwYXNzPT0=';
        $text = 'First QWxhZGRpbjpvcGVu then dXNlcjpwYXNzPT0=';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'QWxhZGRpbjpvcGVu';
        $text = 'QWxhZGRpbjpvcGVu tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'QWxhZGRpbjpvcGVu';
        $text = 'head QWxhZGRpbjpvcGVu';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'QWxhZGRpbjpvcGVu';
        $text = 'Check QWxhZGRpbjpvcGVu, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expectedFirst = 'QWxhZGRpbjpvcGVu';
        $expectedSecond = 'QWxhZGRpbjpvcGVu';
        $text = 'QWxhZGRpbjpvcGVu and QWxhZGRpbjpvcGVu';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'dXNlcjpwYXNzPT0=';
        $text = 'Prefix dXNlcjpwYXNzPT0= suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expectedFirst = 'QWxhZGRpbjpvcGVu';
        $expectedSecond = 'dXNlcjpwYXNzPT0=';
        $text = 'QWxhZGRpbjpvcGVu, dXNlcjpwYXNzPT0=';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new BasicAuthBase64Probe();

        $expected = 'QWxhZGRpbjpvcGVu';
        $text = 'Value: QWxhZGRpbjpvcGVu';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::BASIC_AUTH_BASE64, $results[0]->getProbeType());
    }
}
