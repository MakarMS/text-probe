<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\TerraformBackendS3Probe;

/**
 * @internal
 */
class TerraformBackendS3ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TerraformBackendS3Probe();

        $first = 'backend "s3"';
        $second = 'backend "s3"';
        $text = 'backend "s3"' . "\n" . 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new TerraformBackendS3Probe();

        $text = 'backend "azurerm"';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TerraformBackendS3Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TerraformBackendS3Probe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new TerraformBackendS3Probe();

        $expected = 'backend "s3"';
        $text = 'backend "s3"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_BACKEND_S3, $results[0]->getProbeType());
    }
}
