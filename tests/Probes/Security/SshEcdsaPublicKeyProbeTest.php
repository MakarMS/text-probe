<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\SshEcdsaPublicKeyProbe;

/**
 * @internal
 */
class SshEcdsaPublicKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'Value: ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'Value: ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expectedFirst = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $expectedSecond = 'ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA, ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(56, $results[1]->getStart());
        $this->assertSame(110, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'head ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(59, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'Check ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expectedFirst = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $expectedSecond = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA, ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(56, $results[1]->getStart());
        $this->assertSame(110, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'Prefix ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expectedFirst = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $expectedSecond = 'ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA; ecdsa-sha2-nistp384 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(56, $results[1]->getStart());
        $this->assertSame(110, $results[1]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SshEcdsaPublicKeyProbe();

        $expected = 'ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $text = 'Value: ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::SSH_ECDSA_PUBLIC_KEY, $results[0]->getProbeType());
    }
}
