<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\TwilioAuthTokenProbe;

/**
 * @internal
 */
class TwilioAuthTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TwilioAuthTokenProbe();

        $expected = 'abcdefabcdefabcdefabcdefabcdefab';
        $text = 'Value: abcdefabcdefabcdefabcdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWILIO_AUTH_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TwilioAuthTokenProbe();

        $expected = 'abcdefabcdefabcdefabcdefabcdefab';
        $text = 'First abcdefabcdefabcdefabcdefabcdefab then abcdefabcdefabcdefabcdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::TWILIO_AUTH_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::TWILIO_AUTH_TOKEN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new TwilioAuthTokenProbe();

        $text = 'Value: abcdef';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TwilioAuthTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TwilioAuthTokenProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
