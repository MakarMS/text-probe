<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesLabelSelectorProbe;

/**
 * @internal
 */
class KubernetesLabelSelectorProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new KubernetesLabelSelectorProbe();

        $expected = 'app=api,tier=web';
        $text = 'Value: app=api,tier=web';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_LABEL_SELECTOR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new KubernetesLabelSelectorProbe();

        $expected = 'app=api,tier=web';
        $text = 'First app=api,tier=web then app=api,tier=web';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_LABEL_SELECTOR, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_LABEL_SELECTOR, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new KubernetesLabelSelectorProbe();

        $text = 'Value: app-api';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new KubernetesLabelSelectorProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new KubernetesLabelSelectorProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
