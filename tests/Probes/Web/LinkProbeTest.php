<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\LinkProbe;

/**
 * @internal
 */
class LinkProbeTest extends TestCase
{
    public function testFindsHttpLinks(): void
    {
        $probe = new LinkProbe();

        $text = 'Visit https://example.com and http://sub.domain.co.uk/page';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('https://example.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());

        $this->assertEquals('http://sub.domain.co.uk/page', $results[1]->getResult());
        $this->assertEquals(30, $results[1]->getStart());
        $this->assertEquals(58, $results[1]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[1]->getProbeType());
    }

    public function testFindsMixedLinks(): void
    {
        $probe = new LinkProbe();

        $text = 'Check https://site.com and some text, then http://another-site.org/page';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('https://site.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());

        $this->assertEquals('http://another-site.org/page', $results[1]->getResult());
        $this->assertEquals(43, $results[1]->getStart());
        $this->assertEquals(71, $results[1]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[1]->getProbeType());
    }

    public function testNoLinksReturnsEmpty(): void
    {
        $probe = new LinkProbe();

        $text = 'No links here, just plain text.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testFindsSingleLink(): void
    {
        $probe = new LinkProbe();

        $text = 'Visit http://example.org for info.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('http://example.org', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(24, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testLinkWithGetParameters(): void
    {
        $probe = new LinkProbe();

        $text = 'Check https://example.com/search?q=php+regex&sort=asc for details.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://example.com/search?q=php+regex&sort=asc', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(53, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testLinkWithLinkAsGetParameter(): void
    {
        $probe = new LinkProbe();

        $text = 'Visit https://example.com/redirect?url=https%3A%2F%2Fother-site.com%2Fpage';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://example.com/redirect?url=https%3A%2F%2Fother-site.com%2Fpage', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(74, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testLinkSurroundedByText(): void
    {
        $probe = new LinkProbe();

        $text = 'Here is a link: https://example.com/page.html, please visit it.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://example.com/page.html', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(45, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testFindsLinksWithoutProtocol(): void
    {
        $probe = new LinkProbe();

        $text = 'Check www.example.com and another.net/path for details.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('www.example.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());

        $this->assertEquals('another.net/path', $results[1]->getResult());
        $this->assertEquals(26, $results[1]->getStart());
        $this->assertEquals(42, $results[1]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[1]->getProbeType());
    }

    public function testFindsIpv4Links(): void
    {
        $probe = new LinkProbe();

        $text = 'Connect to 127.0.0.1 or https://8.8.8.8:8080/dns-query please.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://8.8.8.8:8080/dns-query', $results[0]->getResult());
        $this->assertEquals(24, $results[0]->getStart());
        $this->assertEquals(54, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testFindsIpv6Links(): void
    {
        $probe = new LinkProbe();

        $text = 'A link http://[2001:db8::1]/test and a bare one [::1]!';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('http://[2001:db8::1]/test', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }

    public function testCorrectlyStripsTrailingPunctuation(): void
    {
        $probe = new LinkProbe();

        $text = 'Links: example.com. example.net, example.org; example.edu! And example.io?';
        $results = $probe->probe($text);

        $this->assertCount(5, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());

        $this->assertEquals('example.net', $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(31, $results[1]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[1]->getProbeType());

        $this->assertEquals('example.org', $results[2]->getResult());
        $this->assertEquals(33, $results[2]->getStart());
        $this->assertEquals(44, $results[2]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[2]->getProbeType());

        $this->assertEquals('example.edu', $results[3]->getResult());
        $this->assertEquals(46, $results[3]->getStart());
        $this->assertEquals(57, $results[3]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[3]->getProbeType());

        $this->assertEquals('example.io', $results[4]->getResult());
        $this->assertEquals(63, $results[4]->getStart());
        $this->assertEquals(73, $results[4]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[4]->getProbeType());
    }

    public function testKnownLimitationUrlEndingInQuestionMark(): void
    {
        $probe = new LinkProbe();

        $text = 'Is the page at https://example.com/search?';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('https://example.com/search', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(41, $results[0]->getEnd());
        $this->assertEquals(ProbeType::LINK, $results[0]->getProbeType());
    }
}
