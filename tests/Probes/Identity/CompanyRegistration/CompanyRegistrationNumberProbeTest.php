<?php

namespace Tests\Probes\Identity\CompanyRegistration;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Identity\CompanyRegistration\CompanyRegistrationNumberProbe;

/**
 * @internal
 */
class CompanyRegistrationNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = '73282932000017';
        $text = "Value:\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = 'CHE-123.456.789';
        $text = "Value:\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expectedFirst = '73282932000017';
        $expectedSecond = 'CHE-123.456.789';
        $text = "First\n" . $expectedFirst . "\nthen\n" . $expectedSecond;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(41, $results[1]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = 'CHE-123.456.789';
        $text = $expected . "\nTail";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = '73282932000017';
        $text = "Head\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = 'CHE-123.456.789';
        $text = "Check\n" . $expected . "\nEnd.";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = '73282932000017';
        $text = $expected . "\nAND\n" . $expected;
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $firstStart = 0;
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expected = 'CHE-123.456.789';
        $text = "Prefix\n" . $expected . "\nSuffix";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $expectedFirst = '73282932000017';
        $expectedSecond = 'CHE-123.456.789';
        $text = "First:\n" . $expectedFirst . "\nAnd:\n" . $expectedSecond . "\nEnd.";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(27, $results[1]->getStart());
        $this->assertSame(42, $results[1]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsInvalidFormat(): void
    {
        $probe = new CompanyRegistrationNumberProbe();

        $text = "Invalid\nINVALID-\nTail";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
