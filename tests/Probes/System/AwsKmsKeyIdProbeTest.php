<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AwsKmsKeyIdProbe;

/**
 * @internal
 */
class AwsKmsKeyIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $first = '12345678-1234-1234-1234-123456789abc';
        $second = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = '12345678-1234-1234-1234-123456789abc' . "\n" . 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $text = 'kms-key-name';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AwsKmsKeyIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_KMS_KEY_ID, $results[0]->getProbeType());
    }
}
