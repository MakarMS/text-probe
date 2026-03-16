<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\FirebaseServerKeyProbe;

/**
 * @internal
 */
class FirebaseServerKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new FirebaseServerKeyProbe();

        $expected = 'AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789';
        $text = 'Value: AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::FIREBASE_SERVER_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new FirebaseServerKeyProbe();

        $expected = 'AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789';
        $text = 'First AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789 then AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::FIREBASE_SERVER_KEY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(66, $results[1]->getStart());
        $this->assertSame(120, $results[1]->getEnd());
        $this->assertSame(ProbeType::FIREBASE_SERVER_KEY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new FirebaseServerKeyProbe();

        $text = 'Value: AAAA:key';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new FirebaseServerKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new FirebaseServerKeyProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
