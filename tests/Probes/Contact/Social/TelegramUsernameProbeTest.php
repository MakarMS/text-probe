<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\TelegramUsernameProbe;

/**
 * @internal
 */
class TelegramUsernameProbeTest extends TestCase
{
    public function testFindsSimpleUsernamesWithPositions(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Hello @username and @user_name123!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@username', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@user_name123', $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(33, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testFindsUsernamesAtTextEdges(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = '@startUser some text @endUser';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@startUser', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(10, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@endUser', $results[1]->getResult());
        $this->assertEquals(21, $results[1]->getStart());
        $this->assertEquals(29, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testIgnoresInvalidUsernames(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Invalid @ab @u$er @user! @us er';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsUsernamesWithNumbersAndUnderscores(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Contact @user123 and @user_name_456 now.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@user123', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@user_name_456', $results[1]->getResult());
        $this->assertEquals(21, $results[1]->getStart());
        $this->assertEquals(35, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testRejectsTooShortUsernames(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Invalid @abcd but ok @abcde';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = '@abcde';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());
    }

    public function testRejectsTooLongUsernames(): void
    {
        $probe = new TelegramUsernameProbe();

        $tooLong = '@' . str_repeat('a', 33);
        $valid = '@' . str_repeat('b', 32);
        $text = "Bad {$tooLong} good {$valid}";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $truncated = '@' . str_repeat('a', 32);
        $this->assertEquals($truncated, $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(37, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $this->assertEquals($valid, $results[1]->getResult());
        $this->assertEquals(44, $results[1]->getStart());
        $this->assertEquals(77, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testFindsUsernamesNearPunctuation(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Ping @nearby, or @enduser!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = '@nearby';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $second = '@enduser';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(17, $results[1]->getStart());
        $this->assertEquals(25, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testFindsMixedCaseUsernames(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Hello @UserName and @AnotherUser.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = '@UserName';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $second = '@AnotherUser';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(32, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testFindsUsernamesWithNumbersOnly(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = 'Accounts @user2024 and @team42 are active.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $first = '@user2024';
        $this->assertEquals($first, $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());

        $second = '@team42';
        $this->assertEquals($second, $results[1]->getResult());
        $this->assertEquals(23, $results[1]->getStart());
        $this->assertEquals(30, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[1]->getProbeType());
    }

    public function testFindsUsernamesAtLineStart(): void
    {
        $probe = new TelegramUsernameProbe();

        $text = '@lineuser is here';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $expected = '@lineuser';
        $this->assertEquals($expected, $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USERNAME, $results[0]->getProbeType());
    }
}
