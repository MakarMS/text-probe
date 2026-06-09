<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\AnthropicApiKeyProbe;

/**
 * @internal
 */
class AnthropicApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'sk-ant-api03-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $first = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $second = 'sk-ant-api03-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456' . "\n" . 'sk-ant-api03-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(47, $results[1]->getStart());
        $this->assertSame(93, $results[1]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $text = 'sk-ant-api03-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AnthropicApiKeyProbe();

        $expected = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANTHROPIC_API_KEY, $results[0]->getProbeType());
    }
}
