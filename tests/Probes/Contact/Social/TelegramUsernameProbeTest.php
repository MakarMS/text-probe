<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\TelegramUsernameProbe;

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
}
