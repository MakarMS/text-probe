<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\PrometheusLabelSetProbe;

/**
 * @internal
 */
class PrometheusLabelSetProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{method="GET",code="200"}';
        $text = '{method="GET",code="200"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{job="api"}';
        $text = '{job="api"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $first = '{method="GET",code="200"}';
        $second = '{job="api"}';
        $text = '{method="GET",code="200"}' . "\n" . '{job="api"}';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{method="GET",code="200"}';
        $text = '{method="GET",code="200"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{method="GET",code="200"}';
        $text = '{method="GET",code="200"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{method="GET",code="200"}';
        $text = '{method="GET",code="200"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $text = '{9label="bad"}';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new PrometheusLabelSetProbe();

        $expected = '{method="GET",code="200"}';
        $text = '{method="GET",code="200"}';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_LABEL_SET, $results[0]->getProbeType());
    }
}
