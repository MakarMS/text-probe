<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AwsArnProbe;

/**
 * @internal
 */
class AwsArnProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/S3Access';
        $text = 'Value: arn:aws:iam::123456789012:role/S3Access';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ARN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/S3Access';
        $text = 'First arn:aws:iam::123456789012:role/S3Access then arn:aws:iam::123456789012:role/S3Access';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_ARN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(51, $results[1]->getStart());
        $this->assertSame(90, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_ARN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new AwsArnProbe();

        $text = 'Value: arn:aws:iam::role/S3Access';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsArnProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsArnProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
