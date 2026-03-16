<?php

namespace Tests\Probes\Contact;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\EmailHeaderMessageIdProbe;

/**
 * @internal
 */
class EmailHeaderMessageIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EmailHeaderMessageIdProbe();

        $expected = 'Message-ID: <abc123@example.com>';
        $text = 'Value: Message-ID: <abc123@example.com>';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_HEADER_MESSAGE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EmailHeaderMessageIdProbe();

        $expected = 'Message-ID: <abc123@example.com>';
        $text = 'First Message-ID: <abc123@example.com> then Message-ID: <abc123@example.com>';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::EMAIL_HEADER_MESSAGE_ID, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::EMAIL_HEADER_MESSAGE_ID, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new EmailHeaderMessageIdProbe();

        $text = 'Value: Message-ID abc123@example.com';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new EmailHeaderMessageIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new EmailHeaderMessageIdProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
