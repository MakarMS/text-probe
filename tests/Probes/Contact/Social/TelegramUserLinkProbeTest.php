<?php

namespace Tests\Probes\Contact\Social;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\Social\TelegramUserLinkProbe;

/**
 * @internal
 */
class TelegramUserLinkProbeTest extends TestCase
{
    public function testFindsSimpleTelegramLinks(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'Join https://t.me/username and https://telegram.me/user_name123!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('https://t.me/username', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[0]->getProbeType());

        $this->assertEquals('https://telegram.me/user_name123', $results[1]->getResult());
        $this->assertEquals(31, $results[1]->getStart());
        $this->assertEquals(63, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[1]->getProbeType());
    }

    public function testFindsTelegramDogLinks(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'Check this out: http://telegram.dog/my_user!';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('http://telegram.dog/my_user', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(43, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidTelegramLinks(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'Invalid links https://t.me/u https://telegram.me/us @notalink';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsTelegramLinksAtTextEdges(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'https://t.me/startUser some text https://telegram.me/endUser';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('https://t.me/startUser', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[0]->getProbeType());

        $this->assertEquals('https://telegram.me/endUser', $results[1]->getResult());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(60, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[1]->getProbeType());
    }

    public function testFindsTelegramLinksWithNumbersAndUnderscores(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'Visit https://t.me/user123 and http://telegram.me/user_name_456 now.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('https://t.me/user123', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(26, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[0]->getProbeType());

        $this->assertEquals('http://telegram.me/user_name_456', $results[1]->getResult());
        $this->assertEquals(31, $results[1]->getStart());
        $this->assertEquals(63, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[1]->getProbeType());
    }

    public function testFindsTelegramLinksWithParameters(): void
    {
        $probe = new TelegramUserLinkProbe();

        $text = 'Check this link: https://t.me/username?start=123&ref=abc#section';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://t.me/username?start=123&ref=abc#section', $results[0]->getResult());
        $this->assertEquals(17, $results[0]->getStart());
        $this->assertEquals(64, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TELEGRAM_USER_LINK, $results[0]->getProbeType());
    }
}
