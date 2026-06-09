<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AwsEc2InstanceIdProbe;

/**
 * @internal
 */
class AwsEc2InstanceIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-1234567890abcdef0';
        $text = 'i-1234567890abcdef0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-abcdef12';
        $text = 'i-abcdef12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $first = 'i-1234567890abcdef0';
        $second = 'i-abcdef12';
        $text = 'i-1234567890abcdef0' . "\n" . 'i-abcdef12';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(20, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-1234567890abcdef0';
        $text = 'i-1234567890abcdef0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-1234567890abcdef0';
        $text = 'i-1234567890abcdef0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-1234567890abcdef0';
        $text = 'i-1234567890abcdef0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $text = 'i-xyz';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AwsEc2InstanceIdProbe();

        $expected = 'i-1234567890abcdef0';
        $text = 'i-1234567890abcdef0';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_EC2_INSTANCE_ID, $results[0]->getProbeType());
    }
}
