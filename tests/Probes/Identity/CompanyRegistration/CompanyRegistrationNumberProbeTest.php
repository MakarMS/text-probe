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
        $this->assertSame(strlen("Value:\n"), $results[0]->getStart());
        $this->assertSame(strlen("Value:\n") + strlen($expected), $results[0]->getEnd());
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
        $this->assertSame(strlen("Value:\n"), $results[0]->getStart());
        $this->assertSame(strlen("Value:\n") + strlen($expected), $results[0]->getEnd());
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
        $firstStart = strpos($text, $expectedFirst);
        $firstEnd = $firstStart + strlen($expectedFirst);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());

        $secondStart = strpos($text, $expectedSecond, $firstEnd);
        $secondEnd = $secondStart + strlen($expectedSecond);
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
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
        $this->assertSame(strlen($expected), $results[0]->getEnd());
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
        $this->assertSame(strlen("Head\n"), $results[0]->getStart());
        $this->assertSame(strlen("Head\n") + strlen($expected), $results[0]->getEnd());
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
        $this->assertSame(strlen("Check\n"), $results[0]->getStart());
        $this->assertSame(strlen("Check\n") + strlen($expected), $results[0]->getEnd());
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
        $firstEnd = strlen($expected);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());

        $secondStart = strpos($text, $expected, $firstEnd);
        $secondEnd = $secondStart + strlen($expected);
        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
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
        $this->assertSame(strlen("Prefix\n"), $results[0]->getStart());
        $this->assertSame(strlen("Prefix\n") + strlen($expected), $results[0]->getEnd());
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
        $firstStart = strpos($text, $expectedFirst);
        $firstEnd = $firstStart + strlen($expectedFirst);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame($firstStart, $results[0]->getStart());
        $this->assertSame($firstEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPANY_REGISTRATION_NUMBER, $results[0]->getProbeType());

        $secondStart = strpos($text, $expectedSecond, $firstEnd);
        $secondEnd = $secondStart + strlen($expectedSecond);
        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame($secondStart, $results[1]->getStart());
        $this->assertSame($secondEnd, $results[1]->getEnd());
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
