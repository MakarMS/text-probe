<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\SocketAddressProbe;

/**
 * @internal
 */
class SocketAddressProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SocketAddressProbe();

        $expected = '[2001:db8::1]:443';
        $text = 'Value: [2001:db8::1]:443';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::SOCKET_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SocketAddressProbe();

        $expected = '[2001:db8::1]:443';
        $text = 'First [2001:db8::1]:443 then [2001:db8::1]:443';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::SOCKET_ADDRESS, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(46, $results[1]->getEnd());
        $this->assertSame(ProbeType::SOCKET_ADDRESS, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SocketAddressProbe();

        $text = 'Value: 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SocketAddressProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SocketAddressProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
