<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AwsIamRoleArnProbe;

/**
 * @internal
 */
class AwsIamRoleArnProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/Admin';
        $text = 'arn:aws:iam::123456789012:role/Admin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws-us-gov:iam::123456789012:role/service-role/LambdaRole';
        $text = 'arn:aws-us-gov:iam::123456789012:role/service-role/LambdaRole';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(61, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $first = 'arn:aws:iam::123456789012:role/Admin';
        $second = 'arn:aws-us-gov:iam::123456789012:role/service-role/LambdaRole';
        $text = 'arn:aws:iam::123456789012:role/Admin' . "\n" . 'arn:aws-us-gov:iam::123456789012:role/service-role/LambdaRole';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(98, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/Admin';
        $text = 'arn:aws:iam::123456789012:role/Admin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/Admin';
        $text = 'arn:aws:iam::123456789012:role/Admin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/Admin';
        $text = 'arn:aws:iam::123456789012:role/Admin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $text = 'arn:aws:iam::123456789012:user/Admin';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AwsIamRoleArnProbe();

        $expected = 'arn:aws:iam::123456789012:role/Admin';
        $text = 'arn:aws:iam::123456789012:role/Admin';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_IAM_ROLE_ARN, $results[0]->getProbeType());
    }
}
