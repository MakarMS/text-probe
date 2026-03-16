<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SendgridApiKeyProbe;

/**
 * @internal
 */
class SendgridApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SendgridApiKeyProbe();

        $expected = 'SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb';
        $text = 'Value: SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(51, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENDGRID_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SendgridApiKeyProbe();

        $expected = 'SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb';
        $text = 'First SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb then SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::SENDGRID_API_KEY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(56, $results[1]->getStart());
        $this->assertSame(100, $results[1]->getEnd());
        $this->assertSame(ProbeType::SENDGRID_API_KEY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SendgridApiKeyProbe();

        $text = 'Value: SG.short.short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SendgridApiKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SendgridApiKeyProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
