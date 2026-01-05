<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GoogleApiKeyProbe;

/**
 * @internal
 */
class GoogleApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Value: AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'Value: AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expectedFirst = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = 'AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'First AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa then AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(84, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'head AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Check AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expectedFirst = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa and AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'Prefix AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expectedFirst = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $expectedSecond = 'AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $text = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa, AIzaSyBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new GoogleApiKeyProbe();

        $expected = 'AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $text = 'Value: AIzaSyAaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_API_KEY, $results[0]->getProbeType());
    }
}
