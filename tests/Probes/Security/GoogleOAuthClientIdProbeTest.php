<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GoogleOAuthClientIdProbe;

/**
 * @internal
 */
class GoogleOAuthClientIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '9876543210987654321-ABCDEabcde12345_-xyz.apps.googleusercontent.com';
        $text = '9876543210987654321-ABCDEabcde12345_-xyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $first = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $second = '9876543210987654321-ABCDEabcde12345_-xyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com' . "\n" . '9876543210987654321-ABCDEabcde12345_-xyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(67, $results[1]->getStart());
        $this->assertSame(134, $results[1]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $text = '123-short.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new GoogleOAuthClientIdProbe();

        $expected = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $text = '123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::GOOGLE_OAUTH_CLIENT_ID, $results[0]->getProbeType());
    }
}
