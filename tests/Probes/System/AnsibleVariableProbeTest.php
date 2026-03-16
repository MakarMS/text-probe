<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AnsibleVariableProbe;

/**
 * @internal
 */
class AnsibleVariableProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AnsibleVariableProbe();

        $expected = '{{ inventory_hostname }}';
        $text = 'Value: {{ inventory_hostname }}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(31, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_VARIABLE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AnsibleVariableProbe();

        $expected = '{{ inventory_hostname }}';
        $text = 'First {{ inventory_hostname }} then {{ inventory_hostname }}';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_VARIABLE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(36, $results[1]->getStart());
        $this->assertSame(60, $results[1]->getEnd());
        $this->assertSame(ProbeType::ANSIBLE_VARIABLE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new AnsibleVariableProbe();

        $text = 'Value: { inventory_hostname }';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AnsibleVariableProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AnsibleVariableProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
