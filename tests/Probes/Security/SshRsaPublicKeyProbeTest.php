<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SshRsaPublicKeyProbe;

/**
 * @internal
 */
class SshRsaPublicKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'Value: ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $text = 'Value: ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expectedFirst = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $expectedSecond = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $text = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7, ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'head ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'Check ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expectedFirst = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $expectedSecond = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7, ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $text = 'Prefix ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expectedFirst = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $expectedSecond = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $text = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7; ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQD1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(42, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SshRsaPublicKeyProbe();

        $expected = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $text = 'Value: ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_RSA_PUBLIC_KEY, $results[0]->getProbeType());
    }
}
