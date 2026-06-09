<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\CloudflareApiTokenProbe;

/**
 * @internal
 */
class CloudflareApiTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = '1234567890abcdefghijklmnopqrstuvwxyzABCD';
        $text = '1234567890abcdefghijklmnopqrstuvwxyzABCD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $first = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $second = '1234567890abcdefghijklmnopqrstuvwxyzABCD';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN' . "\n" . '1234567890abcdefghijklmnopqrstuvwxyzABCD';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(81, $results[1]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $text = 'cloudflare-token-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new CloudflareApiTokenProbe();

        $expected = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $text = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_API_TOKEN, $results[0]->getProbeType());
    }
}
