<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesAnnotationKeyProbe;

/**
 * @internal
 */
class KubernetesAnnotationKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new KubernetesAnnotationKeyProbe();

        $expected = 'example.com/owner';
        $text = 'Value: example.com/owner';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_ANNOTATION_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new KubernetesAnnotationKeyProbe();

        $expected = 'example.com/owner';
        $text = 'First example.com/owner then example.com/owner';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_ANNOTATION_KEY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(29, $results[1]->getStart());
        $this->assertSame(46, $results[1]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_ANNOTATION_KEY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new KubernetesAnnotationKeyProbe();

        $text = 'Value: owner/';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new KubernetesAnnotationKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new KubernetesAnnotationKeyProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
