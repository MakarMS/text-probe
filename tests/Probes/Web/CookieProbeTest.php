<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CookieProbe;

/**
 * @internal
 */
class CookieProbeTest extends TestCase
{
    public function testSetCookieHeader(): void
    {
        $probe = new CookieProbe();

        $text = 'Set-Cookie: sessionId=abc123; Path=/; HttpOnly';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('Set-Cookie: sessionId=abc123', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTTP_COOKIE, $results[0]->getProbeType());
    }

    public function testCookieHeaderMultiplePairs(): void
    {
        $probe = new CookieProbe();

        $text = 'Cookie: sessionId=abc123; theme=light; logged=true';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('Cookie: sessionId=abc123', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());

        $this->assertEquals('theme=light', $results[1]->getResult());
        $this->assertEquals(26, $results[1]->getStart());
        $this->assertEquals(37, $results[1]->getEnd());

        $this->assertEquals('logged=true', $results[2]->getResult());
        $this->assertEquals(39, $results[2]->getStart());
        $this->assertEquals(50, $results[2]->getEnd());
    }

    public function testQuotedCookieValue(): void
    {
        $probe = new CookieProbe();

        $text = 'Set-Cookie: prefs="a=b; c=d"; Secure';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('Set-Cookie: prefs="a=b; c=d"', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(28, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HTTP_COOKIE, $results[0]->getProbeType());
    }

    public function testIgnoresAttributesWithoutCookiePair(): void
    {
        $probe = new CookieProbe();

        $text = 'Set-Cookie: Path=/; Secure; HttpOnly';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testStandaloneCookieFragments(): void
    {
        $probe = new CookieProbe();

        $text = 'Auth cookies: sessionid=xyz789 token=abc42';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('sessionid=xyz789', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());

        $this->assertEquals('token=abc42', $results[1]->getResult());
        $this->assertEquals(31, $results[1]->getStart());
        $this->assertEquals(42, $results[1]->getEnd());
    }
}
