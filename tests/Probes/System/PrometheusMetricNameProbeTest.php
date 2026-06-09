<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\PrometheusMetricNameProbe;

/**
 * @internal
 */
class PrometheusMetricNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'http_requests_total';
        $text = 'http_requests_total';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'node:cpu_seconds:sum';
        $text = 'node:cpu_seconds:sum';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $first = 'http_requests_total';
        $second = 'node:cpu_seconds:sum';
        $text = 'http_requests_total' . "\n" . 'node:cpu_seconds:sum';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(20, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'http_requests_total';
        $text = 'http_requests_total';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'http_requests_total';
        $text = 'http_requests_total';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'http_requests_total';
        $text = 'http_requests_total';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $text = '9metric';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new PrometheusMetricNameProbe();

        $expected = 'http_requests_total';
        $text = 'http_requests_total';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::PROMETHEUS_METRIC_NAME, $results[0]->getProbeType());
    }
}
