<?php

namespace Tests\Probes\Text;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Text\AllCapsSequenceProbe;

/**
 * @internal
 */
class AllCapsSequenceProbeTest extends TestCase
{
    public function testFindsMultipleUppercaseSequencesWithOffsets(): void
    {
        $probe = new AllCapsSequenceProbe();

        $text = 'The ALERT occurred BEFORE shutdown.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('ALERT', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[0]->getProbeType());

        $this->assertEquals('BEFORE', $results[1]->getResult());
        $this->assertEquals(19, $results[1]->getStart());
        $this->assertEquals(25, $results[1]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[1]->getProbeType());
    }

    public function testIgnoresSingleLetters(): void
    {
        $probe = new AllCapsSequenceProbe();

        $text = 'This is a test with A and B only.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testHandlesPunctuationBoundaries(): void
    {
        $probe = new AllCapsSequenceProbe();

        $text = 'Payload ready: NASA, then ESA.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('NASA', $results[0]->getResult());
        $this->assertEquals(15, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[0]->getProbeType());

        $this->assertEquals('ESA', $results[1]->getResult());
        $this->assertEquals(26, $results[1]->getStart());
        $this->assertEquals(29, $results[1]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[1]->getProbeType());
    }

    public function testSkipsMixedCaseWords(): void
    {
        $probe = new AllCapsSequenceProbe();

        $text = 'Processing HTTP headers and XML but not XmlHttp.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('HTTP', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[0]->getProbeType());

        $this->assertEquals('XML', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(31, $results[1]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[1]->getProbeType());
    }

    public function testSupportsUnicodeUppercaseSequences(): void
    {
        $probe = new AllCapsSequenceProbe();

        $text = 'Сообщение от МИР и ОСЕНЬ в чате';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('МИР', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[0]->getProbeType());

        $this->assertEquals('ОСЕНЬ', $results[1]->getResult());
        $this->assertEquals(19, $results[1]->getStart());
        $this->assertEquals(24, $results[1]->getEnd());
        $this->assertEquals(ProbeType::ALL_CAPS_SEQUENCE, $results[1]->getProbeType());
    }
}
