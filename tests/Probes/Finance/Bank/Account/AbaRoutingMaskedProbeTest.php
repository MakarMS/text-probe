<?php

namespace Tests\Probes\Finance\Bank\Account;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Bank\Account\AbaRoutingMaskedProbe;

/**
 * @internal
 */
class AbaRoutingMaskedProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AbaRoutingMaskedProbe();

        $expected = '*****6789';
        $text = 'Value: *****6789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::ABA_ROUTING_MASKED, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AbaRoutingMaskedProbe();

        $expected = '*****6789';
        $text = 'First *****6789 then *****6789';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::ABA_ROUTING_MASKED, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::ABA_ROUTING_MASKED, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new AbaRoutingMaskedProbe();

        $text = 'Value: ***6789';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AbaRoutingMaskedProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AbaRoutingMaskedProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
