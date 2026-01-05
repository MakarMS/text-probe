<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SshEd25519PublicKeyProbe;

/**
 * @internal
 */
class SshEd25519PublicKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'Value: ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $text = 'Value: ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expectedFirst = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $expectedSecond = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $text = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3, ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'head ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'Check ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expectedFirst = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $expectedSecond = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3, ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $text = 'Prefix ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expectedFirst = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $expectedSecond = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $text = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3; ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC4';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SshEd25519PublicKeyProbe();

        $expected = 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $text = 'Value: ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIC3';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ED25519_PUBLIC_KEY, $results[0]->getProbeType());
    }
}
