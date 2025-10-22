<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\UserAgentProbe;

class UserAgentProbeTest extends TestCase
{
    public function testFindsUAWithSurroundingText(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Log entry: curl/7.68.0 requested /index.html';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('curl/7.68.0', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }

    public function testFindsUAAfterPunctuation(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Error: Mozilla/5.0 (Windows NT 10.0; Win64; x64), connection failed';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('Mozilla/5.0 (Windows NT 10.0; Win64; x64)', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(48, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }

    public function testFindsUAAtStartOfText(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_2 like Mac OS X) accessed the page';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('Mozilla/5.0 (iPhone; CPU iPhone OS 14_2 like Mac OS X)', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(54, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }

    public function testFindsUAAtEndOfText(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Request sent by Opera/88.0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('Opera/88.0', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }

    public function testFindsUAInTextWithoutClearSeparators(): void
    {
        $probe = new UserAgentProbe();

        $text = 'User accessed:CustomBot/1.2(Linux x86_64)next log line';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('CustomBot/1.2(Linux x86_64)', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(41, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }

    public function testFindsMultipleUAsWithOtherText(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Start curl/7.68.0, then Mozilla/5.0 (Windows) accessed site';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('curl/7.68.0', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());

        $this->assertEquals('Mozilla/5.0 (Windows)', $results[1]->getResult());
        $this->assertEquals(24, $results[1]->getStart());
        $this->assertEquals(45, $results[1]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[1]->getProbeType());
    }

    public function testFindsUAWithTrailingTextInsideParentheses(): void
    {
        $probe = new UserAgentProbe();

        $text = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) extra info';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('Mozilla/5.0 (Windows NT 10.0; Win64; x64)', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(41, $results[0]->getEnd());
        $this->assertEquals(ProbeType::USER_AGENT, $results[0]->getProbeType());
    }
}
