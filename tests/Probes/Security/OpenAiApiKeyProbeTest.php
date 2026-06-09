<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\OpenAiApiKeyProbe;

/**
 * @internal
 */
class OpenAiApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'sk-abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $first = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $second = 'sk-abcdefghijklmnopqrstuvwxyz1234567890';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456' . "\n" . 'sk-abcdefghijklmnopqrstuvwxyz1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(81, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $text = 'sk-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpenAiApiKeyProbe();

        $expected = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-proj-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENAI_API_KEY, $results[0]->getProbeType());
    }
}
