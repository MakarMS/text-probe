<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\TerraformModuleSourceProbe;

/**
 * @internal
 */
class TerraformModuleSourceProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'terraform-aws-modules/vpc/aws';
        $text = 'terraform-aws-modules/vpc/aws';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'git::https://github.com/org/module.git';
        $text = 'git::https://github.com/org/module.git';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $first = 'terraform-aws-modules/vpc/aws';
        $second = 'git::https://github.com/org/module.git';
        $text = 'terraform-aws-modules/vpc/aws' . "\n" . 'git::https://github.com/org/module.git';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(30, $results[1]->getStart());
        $this->assertSame(68, $results[1]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'terraform-aws-modules/vpc/aws';
        $text = 'terraform-aws-modules/vpc/aws';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'terraform-aws-modules/vpc/aws';
        $text = 'terraform-aws-modules/vpc/aws';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'terraform-aws-modules/vpc/aws';
        $text = 'terraform-aws-modules/vpc/aws';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $text = 'module source';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new TerraformModuleSourceProbe();

        $expected = 'terraform-aws-modules/vpc/aws';
        $text = 'terraform-aws-modules/vpc/aws';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_MODULE_SOURCE, $results[0]->getProbeType());
    }
}
