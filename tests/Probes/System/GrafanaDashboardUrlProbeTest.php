<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GrafanaDashboardUrlProbe;

/**
 * @internal
 */
class GrafanaDashboardUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'https://grafana.example.com/d/abc123/service';
        $text = 'https://grafana.example.com/d/abc123/service';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'http://localhost:3000/d/node_exporter';
        $text = 'http://localhost:3000/d/node_exporter';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $first = 'https://grafana.example.com/d/abc123/service';
        $second = 'http://localhost:3000/d/node_exporter';
        $text = 'https://grafana.example.com/d/abc123/service' . "\n" . 'http://localhost:3000/d/node_exporter';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(45, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'https://grafana.example.com/d/abc123/service';
        $text = 'https://grafana.example.com/d/abc123/service';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'https://grafana.example.com/d/abc123/service';
        $text = 'https://grafana.example.com/d/abc123/service';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'https://grafana.example.com/d/abc123/service';
        $text = 'https://grafana.example.com/d/abc123/service';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $text = 'https://grafana.example.com/dashboard/abc';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new GrafanaDashboardUrlProbe();

        $expected = 'https://grafana.example.com/d/abc123/service';
        $text = 'https://grafana.example.com/d/abc123/service';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAFANA_DASHBOARD_URL, $results[0]->getProbeType());
    }
}
