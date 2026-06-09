<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GcpPubSubTopicProbe;

/**
 * @internal
 */
class GcpPubSubTopicProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/my-project-123/topics/events';
        $text = 'projects/my-project-123/topics/events';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/prod123456/topics/audit.logs';
        $text = 'projects/prod123456/topics/audit.logs';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $first = 'projects/my-project-123/topics/events';
        $second = 'projects/prod123456/topics/audit.logs';
        $text = 'projects/my-project-123/topics/events' . "\n" . 'projects/prod123456/topics/audit.logs';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(75, $results[1]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/my-project-123/topics/events';
        $text = 'projects/my-project-123/topics/events';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/my-project-123/topics/events';
        $text = 'projects/my-project-123/topics/events';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/my-project-123/topics/events';
        $text = 'projects/my-project-123/topics/events';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $text = 'projects/x/topics/a';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new GcpPubSubTopicProbe();

        $expected = 'projects/my-project-123/topics/events';
        $text = 'projects/my-project-123/topics/events';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
        $this->assertSame(ProbeType::GCP_PUBSUB_TOPIC, $results[0]->getProbeType());
    }
}
