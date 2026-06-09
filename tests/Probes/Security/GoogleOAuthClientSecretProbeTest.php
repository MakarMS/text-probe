<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GoogleOAuthClientSecretProbe;

/**
 * @internal
 */
class GoogleOAuthClientSecretProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'GOCSPX-ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $first = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $second = 'GOCSPX-ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz' . "\n" . 'GOCSPX-ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(34, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $text = 'GOCSPX-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new GoogleOAuthClientSecretProbe();

        $expected = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $text = 'GOCSPX-abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_SECRET, $results[0]->getProbeType());
    }
}
