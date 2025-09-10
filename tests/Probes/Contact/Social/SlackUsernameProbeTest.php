<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\SlackUsernameProbe;

class SlackUsernameProbeTest extends TestCase
{
    public function testFindsValidUsernamesWithPositions(): void
    {
        $probe = new SlackUsernameProbe();

        $text = 'Any @makarms and @user.name.123 or @anyUsername';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('@makarms', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@user.name.123', $results[1]->getResult());
        $this->assertEquals(17, $results[1]->getStart());
        $this->assertEquals(31, $results[1]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[1]->getProbeType());

        $this->assertEquals('@anyUsername', $results[2]->getResult());
        $this->assertEquals(35, $results[2]->getStart());
        $this->assertEquals(47, $results[2]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[2]->getProbeType());
    }

    public function testRejectsUsernamesWithDoubleDots(): void
    {
        $probe = new SlackUsernameProbe();

        $text = '@user..name @valid.user';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('@valid.user', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());
    }

    public function testRejectsUsernamesWithoutAtSymbol(): void
    {
        $probe = new SlackUsernameProbe();

        $text = 'user.name @validuser';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('@validuser', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());
    }

    public function testRejectsUsernamesWithInvalidChars(): void
    {
        $probe = new SlackUsernameProbe();

        $text = '@invalid*user @valid_user';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('@valid_user', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(25, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());
    }

    public function testAcceptsUsernamesWithMinimumAndMaximumLength(): void
    {
        $probe = new SlackUsernameProbe();

        $minUsername = '@ab';
        $maxUsername = '@' . str_repeat('a', 32);

        $text = "$minUsername $maxUsername @toolong" . str_repeat('a', 33);
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals($minUsername, $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(3, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());

        $this->assertEquals($maxUsername, $results[1]->getResult());
        $this->assertEquals(4, $results[1]->getStart());
        $this->assertEquals(37, $results[1]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[1]->getProbeType());
    }

    public function testAcceptsUsernamesWithCapitalLetters(): void
    {
        $probe = new SlackUsernameProbe();

        $text = '@UserName @Another_User';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('@UserName', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(9, $results[0]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[0]->getProbeType());

        $this->assertEquals('@Another_User', $results[1]->getResult());
        $this->assertEquals(10, $results[1]->getStart());
        $this->assertEquals(23, $results[1]->getEnd());
        $this->assertEquals(ProbeType::SLACK_USERNAME, $results[1]->getProbeType());
    }
}
