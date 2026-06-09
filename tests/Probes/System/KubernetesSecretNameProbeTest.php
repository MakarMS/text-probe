<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesSecretNameProbe;

/**
 * @internal
 */
class KubernetesSecretNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'db-password';
        $text = 'db-password';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'tls.secret';
        $text = 'tls.secret';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $first = 'db-password';
        $second = 'tls.secret';
        $text = 'db-password' . "\n" . 'tls.secret';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'db-password';
        $text = 'db-password';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'db-password';
        $text = 'db-password';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'db-password';
        $text = 'db-password';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $text = 'Secret_Name';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new KubernetesSecretNameProbe();

        $expected = 'db-password';
        $text = 'db-password';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_SECRET_NAME, $results[0]->getProbeType());
    }
}
