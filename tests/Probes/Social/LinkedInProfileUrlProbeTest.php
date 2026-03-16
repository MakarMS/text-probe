<?php

namespace Tests\Probes\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Social\LinkedInProfileUrlProbe;

/**
 * @internal
 */
class LinkedInProfileUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LinkedInProfileUrlProbe();

        $expected = 'https://linkedin.com/in/john-doe';
        $text = 'Value: https://linkedin.com/in/john-doe';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::LINKEDIN_PROFILE_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LinkedInProfileUrlProbe();

        $expected = 'https://linkedin.com/in/john-doe';
        $text = 'First https://linkedin.com/in/john-doe then https://linkedin.com/in/john-doe';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::LINKEDIN_PROFILE_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::LINKEDIN_PROFILE_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new LinkedInProfileUrlProbe();

        $text = 'Value: linkedin profile';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new LinkedInProfileUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new LinkedInProfileUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
