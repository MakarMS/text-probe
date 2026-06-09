<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AwsLambdaArnProbe;

/**
 * @internal
 */
class AwsLambdaArnProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws-us-gov:lambda:us-gov-west-1:123456789012:function:processor:prod';
        $text = 'arn:aws-us-gov:lambda:us-gov-west-1:123456789012:function:processor:prod';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(72, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsLambdaArnProbe();

        $first = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $second = 'arn:aws-us-gov:lambda:us-gov-west-1:123456789012:function:processor:prod';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor' . "\n" . 'arn:aws-us-gov:lambda:us-gov-west-1:123456789012:function:processor:prod';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(57, $results[1]->getStart());
        $this->assertSame(129, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AwsLambdaArnProbe();

        $text = 'arn:aws:lambda:us-east-1:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsLambdaArnProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsLambdaArnProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AwsLambdaArnProbe();

        $expected = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $text = 'arn:aws:lambda:us-east-1:123456789012:function:processor';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(56, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_LAMBDA_ARN, $results[0]->getProbeType());
    }
}
