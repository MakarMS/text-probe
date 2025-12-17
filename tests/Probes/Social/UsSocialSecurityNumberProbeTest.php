<?php

namespace Tests\Probes\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Social\UsSocialSecurityNumberProbe;

/**
 * @internal
 */
class UsSocialSecurityNumberProbeTest extends TestCase
{
    public function testFindsValidSsnWithPositions(): void
    {
        $probe = new UsSocialSecurityNumberProbe();

        $text = 'Employee SSN: 123-45-6789 is recorded.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('123-45-6789', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::US_SOCIAL_SECURITY_NUMBER, $results[0]->getProbeType());
    }

    public function testRejectsDisallowedAreaNumbers(): void
    {
        $probe = new UsSocialSecurityNumberProbe();

        $text = 'Invalid examples: 000-12-3456, 666-12-3456, 901-12-3456.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testRejectsInvalidGroupOrSerialNumbers(): void
    {
        $probe = new UsSocialSecurityNumberProbe();

        $text = 'These should fail validation: 123-00-4567 and 123-45-0000.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testDoesNotMatchWithoutDashesOrWithExtraDigits(): void
    {
        $probe = new UsSocialSecurityNumberProbe();

        $text = 'Compact 123456789 or extended 123-45-67890 should not match.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMultipleValidSsns(): void
    {
        $probe = new UsSocialSecurityNumberProbe();

        $text = 'Primary: 123-45-6789; Secondary: 321-54-9876 are listed.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('123-45-6789', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::US_SOCIAL_SECURITY_NUMBER, $results[0]->getProbeType());

        $this->assertEquals('321-54-9876', $results[1]->getResult());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(44, $results[1]->getEnd());
        $this->assertEquals(ProbeType::US_SOCIAL_SECURITY_NUMBER, $results[1]->getProbeType());
    }
}
