<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\DomainProbe;

class DomainProbeTest extends TestCase
{
    public function testAsciiDomains(): void
    {
        $probe = new DomainProbe();

        $text = 'Visit example.com and sub.domain.co.uk for info.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('sub.domain.co.uk', $results[1]->getResult());
        $this->assertEquals(22, $results[1]->getStart());
        $this->assertEquals(38, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testUnicodeDomains(): void
    {
        $probe = new DomainProbe();

        $text = 'Check the sites пример.рф and мойдомен.рус';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('пример.рф', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('мойдомен.рус', $results[1]->getResult());
        $this->assertEquals(30, $results[1]->getStart());
        $this->assertEquals(42, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testMixedDomains(): void
    {
        $probe = new DomainProbe();

        $text = 'The sites example.com and пример.рф are working.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('пример.рф', $results[1]->getResult());
        $this->assertEquals(26, $results[1]->getStart());
        $this->assertEquals(35, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testNoDomains(): void
    {
        $probe = new DomainProbe();

        $text = 'This is just some text without domains.';
        $results = $probe->probe($text);

        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testDomainWithHyphen(): void
    {
        $probe = new DomainProbe();

        $text = 'Visit my-site.com and мой-сайт.рф';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('my-site.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('мой-сайт.рф', $results[1]->getResult());
        $this->assertEquals(22, $results[1]->getStart());
        $this->assertEquals(33, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testDomainsInsideUrls(): void
    {
        $probe = new DomainProbe();

        $text = 'Visit https://example.com/path and http://sub.domain.co.uk?query=1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('sub.domain.co.uk', $results[1]->getResult());
        $this->assertEquals(42, $results[1]->getStart());
        $this->assertEquals(58, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testDomainWithoutProtocol(): void
    {
        $probe = new DomainProbe();

        $text = 'Go to www.example.com or ftp.example.org for files.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('www.example.com', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(21, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('ftp.example.org', $results[1]->getResult());
        $this->assertEquals(25, $results[1]->getStart());
        $this->assertEquals(40, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testDomainWithPort(): void
    {
        $probe = new DomainProbe();

        $text = 'Connect to example.com:8080 or secure.example.net:443';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('secure.example.net', $results[1]->getResult());
        $this->assertEquals(31, $results[1]->getStart());
        $this->assertEquals(49, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }

    public function testDomainInsideEmail(): void
    {
        $probe = new DomainProbe();

        $text = 'Send an email to user@example.com or admin@mail.example.org';

        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('example.com', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(33, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[0]->getProbeType());

        $this->assertEquals('mail.example.org', $results[1]->getResult());
        $this->assertEquals(43, $results[1]->getStart());
        $this->assertEquals(59, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DOMAIN, $results[1]->getProbeType());
    }
}
