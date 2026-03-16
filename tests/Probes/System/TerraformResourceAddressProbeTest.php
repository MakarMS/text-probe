<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\TerraformResourceAddressProbe;

/**
 * @internal
 */
class TerraformResourceAddressProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TerraformResourceAddressProbe();

        $expected = 'aws_instance.web[0]';
        $text = 'Value: aws_instance.web[0]';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_RESOURCE_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TerraformResourceAddressProbe();

        $expected = 'aws_instance.web[0]';
        $text = 'First aws_instance.web[0] then aws_instance.web[0]';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_RESOURCE_ADDRESS, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(31, $results[1]->getStart());
        $this->assertSame(50, $results[1]->getEnd());
        $this->assertSame(ProbeType::TERRAFORM_RESOURCE_ADDRESS, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new TerraformResourceAddressProbe();

        $text = 'Value: aws-instance';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TerraformResourceAddressProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TerraformResourceAddressProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
