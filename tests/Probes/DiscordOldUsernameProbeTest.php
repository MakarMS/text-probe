<?php

namespace Tests\Probes;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DiscordOldUsernameProbe;

class DiscordOldUsernameProbeTest extends TestCase
{
    public function testFindsValidUsernamesWithPositions(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'JohnDoe#1234 user_99#0001 Some_Guy#9999';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('JohnDoe#1234', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());

        $this->assertEquals('user_99#0001', $results[1]->getResult());
        $this->assertEquals(13, $results[1]->getStart());
        $this->assertEquals(25, $results[1]->getEnd());

        $this->assertEquals('Some_Guy#9999', $results[2]->getResult());
        $this->assertEquals(26, $results[2]->getStart());
        $this->assertEquals(39, $results[2]->getEnd());

        $this->assertEquals(ProbeType::DISCORD_OLD_USERNAME, $results[0]->getProbeType());
    }

    public function testRejectsInvalidUsernames(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'noTag1234 bad#123 abc#abcd reallylongusernamethatexceedslimit#1234';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testAcceptsMinAndMaxLength(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $minUsername = 'ab#1234';
        $maxName = str_repeat('a', 32);
        $maxUsername = $maxName . '#0001';

        $text = "x $minUsername $maxUsername";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals($minUsername, $results[0]->getResult());
        $this->assertEquals(2, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());

        $this->assertEquals($maxUsername, $results[1]->getResult());
        $this->assertEquals(10, $results[1]->getStart());
        $this->assertEquals(47, $results[1]->getEnd());
    }
}
