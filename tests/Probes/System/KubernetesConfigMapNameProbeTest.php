<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesConfigMapNameProbe;

/**
 * @internal
 */
class KubernetesConfigMapNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'app-config';
        $text = 'app-config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'service.config';
        $text = 'service.config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $first = 'app-config';
        $second = 'service.config';
        $text = 'app-config' . "\n" . 'service.config';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'app-config';
        $text = 'app-config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'app-config';
        $text = 'app-config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'app-config';
        $text = 'app-config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $text = 'Config_Map';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new KubernetesConfigMapNameProbe();

        $expected = 'app-config';
        $text = 'app-config';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_CONFIG_MAP_NAME, $results[0]->getProbeType());
    }
}
