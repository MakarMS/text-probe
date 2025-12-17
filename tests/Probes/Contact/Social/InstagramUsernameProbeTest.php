<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\InstagramUsernameProbe;

/**
 * @internal
 */
class InstagramUsernameProbeTest extends TestCase
{
    public function testFindsMultipleUsernamesWithPositions(): void
    {
        $probe = new InstagramUsernameProbe();

        $text = 'Follow @insta.user and @another_user for updates.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@insta.user', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@another_user', $results[1]->getResult());
        $this->assertEquals(23, $results[1]->getStart());
        $this->assertEquals(36, $results[1]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testRejectsUsernamesWithConsecutiveDots(): void
    {
        $probe = new InstagramUsernameProbe();

        $text = 'Handles @good_name but not @bad..name or @also..bad.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('@good_name', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[0]->getProbeType());
    }

    public function testEnforcesLengthLimits(): void
    {
        $probe = new InstagramUsernameProbe();

        $valid = '@' . str_repeat('a', 30);
        $invalid = '@' . str_repeat('b', 31);

        $text = "Valid: {$valid}, invalid: {$invalid}.";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals($valid, $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(38, $results[0]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[0]->getProbeType());
    }

    public function testAllowsUnderscoresAtEdges(): void
    {
        $probe = new InstagramUsernameProbe();

        $text = 'Check @_leading_name and @_also.valid_123!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@_leading_name', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@_also.valid_123', $results[1]->getResult());
        $this->assertEquals(25, $results[1]->getStart());
        $this->assertEquals(41, $results[1]->getEnd());
        $this->assertEquals(ProbeType::INSTAGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testDoesNotMatchEmails(): void
    {
        $probe = new InstagramUsernameProbe();

        $text = 'Contact us at user.name@example.com or admin@test.org.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
