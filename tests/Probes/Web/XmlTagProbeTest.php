<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\XmlTagProbe;

/**
 * @internal
 */
class XmlTagProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new XmlTagProbe();

        $expected = '<note><to>x</to></note>';
        $text = 'Value: <note><to>x</to></note>';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::XML_TAG, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new XmlTagProbe();

        $expected = '<note><to>x</to></note>';
        $text = 'First <note><to>x</to></note> then <note><to>x</to></note>';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::XML_TAG, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(35, $results[1]->getStart());
        $this->assertSame(58, $results[1]->getEnd());
        $this->assertSame(ProbeType::XML_TAG, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new XmlTagProbe();

        $text = 'Value: xml text';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new XmlTagProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new XmlTagProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
