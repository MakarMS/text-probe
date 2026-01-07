<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\DiscordOldUsernameProbe;

/**
 * @internal
 */
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
        $this->assertEquals(ProbeType::DISCORD_OLD_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('user_99#0001', $results[1]->getResult());
        $this->assertEquals(13, $results[1]->getStart());
        $this->assertEquals(25, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DISCORD_OLD_USERNAME, $results[1]->getProbeType());

        $this->assertEquals('Some_Guy#9999', $results[2]->getResult());
        $this->assertEquals(26, $results[2]->getStart());
        $this->assertEquals(39, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DISCORD_OLD_USERNAME, $results[2]->getProbeType());
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

    public function testAcceptsUsernamesWithDotsAndDashes(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'user.name#1234 user-name#4321';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = 'user.name#1234';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(14, $results[0]->getEnd());

        $second = 'user-name#4321';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(15, $results[1]->getStart());
        $this->assertEquals(29, $results[1]->getEnd());
    }

    public function testRejectsInvalidDiscriminatorLength(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'bad#123 good#1234 bad2#12345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = 'good#1234';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
    }

    public function testRejectsNonDigitDiscriminator(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'wrong#12a4 okname#0001';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = 'okname#0001';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
    }

    public function testRejectsTooShortName(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'a#1234 ok#2345';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = 'ok#2345';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(14, $results[0]->getEnd());
    }

    public function testRejectsEmbeddedUsernamesWithoutWhitespace(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'baduser#1234x good#9999';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = 'good#9999';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
    }

    public function testFindsUsernamesAtTextEdges(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'edge#1111 middle user#2222';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = 'edge#1111';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());

        $second = 'user#2222';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(17, $results[1]->getStart());
        $this->assertEquals(26, $results[1]->getEnd());
    }

    public function testAllowsMixedCaseUsernames(): void
    {
        $probe = new DiscordOldUsernameProbe();

        $text = 'UserName#5555 AnotherName#0002';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = 'UserName#5555';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());

        $second = 'AnotherName#0002';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(14, $results[1]->getStart());
        $this->assertEquals(30, $results[1]->getEnd());
    }
}
