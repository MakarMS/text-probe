<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\AwsSecretAccessKeyProbe;

/**
 * @internal
 */
class AwsSecretAccessKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AwsSecretAccessKeyProbe();

        $expected = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        $text = 'Value: wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_SECRET_ACCESS_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AwsSecretAccessKeyProbe();

        $expected = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        $text = 'First wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY then wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(46, $results[0]->getEnd());
        $this->assertSame(ProbeType::AWS_SECRET_ACCESS_KEY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(52, $results[1]->getStart());
        $this->assertSame(92, $results[1]->getEnd());
        $this->assertSame(ProbeType::AWS_SECRET_ACCESS_KEY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new AwsSecretAccessKeyProbe();

        $text = 'Value: short_secret_key';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AwsSecretAccessKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AwsSecretAccessKeyProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
