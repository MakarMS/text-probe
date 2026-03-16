<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\TwilioSidProbe;

/**
 * @internal
 */
class TwilioSidProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TwilioSidProbe();

        $expected = 'AC1234567890abcdef1234567890abcdef';
        $text = 'Value: AC1234567890abcdef1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWILIO_SID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TwilioSidProbe();

        $expected = 'AC1234567890abcdef1234567890abcdef';
        $text = 'First AC1234567890abcdef1234567890abcdef then AC1234567890abcdef1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWILIO_SID, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(46, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::TWILIO_SID, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new TwilioSidProbe();

        $text = 'Value: AC1234';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TwilioSidProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TwilioSidProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
