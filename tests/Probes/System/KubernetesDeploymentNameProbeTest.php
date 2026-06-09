<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesDeploymentNameProbe;

/**
 * @internal
 */
class KubernetesDeploymentNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'api-deployment';
        $text = 'api-deployment';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'web.prod';
        $text = 'web.prod';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(8, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $first = 'api-deployment';
        $second = 'web.prod';
        $text = 'api-deployment' . "\n" . 'web.prod';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(23, $results[1]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'api-deployment';
        $text = 'api-deployment';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'api-deployment';
        $text = 'api-deployment';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'api-deployment';
        $text = 'api-deployment';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $text = 'deployment_';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new KubernetesDeploymentNameProbe();

        $expected = 'api-deployment';
        $text = 'api-deployment';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_DEPLOYMENT_NAME, $results[0]->getProbeType());
    }
}
