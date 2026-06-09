<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AnsibleInventoryHostProbe;

/**
 * @internal
 */
class AnsibleInventoryHostProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'web01 ansible_host=192.0.2.10';
        $text = 'web01 ansible_host=192.0.2.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'db01.example.com';
        $text = 'db01.example.com';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $first = 'web01 ansible_host=192.0.2.10';
        $second = 'db01.example.com';
        $text = 'web01 ansible_host=192.0.2.10' . "\n" . 'db01.example.com';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(30, $results[1]->getStart());
        $this->assertSame(46, $results[1]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'web01 ansible_host=192.0.2.10';
        $text = 'web01 ansible_host=192.0.2.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'web01 ansible_host=192.0.2.10';
        $text = 'web01 ansible_host=192.0.2.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'web01 ansible_host=192.0.2.10';
        $text = 'web01 ansible_host=192.0.2.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $text = '[webservers]';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AnsibleInventoryHostProbe();

        $expected = 'web01 ansible_host=192.0.2.10';
        $text = 'web01 ansible_host=192.0.2.10';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_INVENTORY_HOST, $results[0]->getProbeType());
    }
}
