<?php

namespace Tests\Probes;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\HashtagProbe;

class HashtagProbeTest extends TestCase
{
    public function testFindsSimpleHashtagsWithPositions(): void
    {
        $probe = new HashtagProbe();

        $text = 'Learning #php and #coding is fun!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('#php', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(13, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[0]->getProbeType());

        $this->assertEquals('#coding', $results[1]->getResult());
        $this->assertEquals(18, $results[1]->getStart());
        $this->assertEquals(25, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[1]->getProbeType());
    }

    public function testIgnoresHashWithoutWord(): void
    {
        $probe = new HashtagProbe();

        $text = 'This is just a # and nothing else.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsHashtagsWithUnderscoreAndDigits(): void
    {
        $probe = new HashtagProbe();

        $text = 'Check out #hello_world and #php8 now!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('#hello_world', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(22, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[0]->getProbeType());

        $this->assertEquals('#php8', $results[1]->getResult());
        $this->assertEquals(27, $results[1]->getStart());
        $this->assertEquals(32, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[1]->getProbeType());
    }

    public function testHashtagsNextToPunctuation(): void
    {
        $probe = new HashtagProbe();

        $text = 'Great work #dev, keep learning #AI!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('#dev', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[0]->getProbeType());

        $this->assertEquals('#AI', $results[1]->getResult());
        $this->assertEquals(31, $results[1]->getStart());
        $this->assertEquals(34, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[1]->getProbeType());
    }

    public function testFindsUnicodeHashtags(): void
    {
        $probe = new HashtagProbe();

        $text = 'Great work #разработчик, keep learning #нейронки!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('#разработчик', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[0]->getProbeType());

        $this->assertEquals('#нейронки', $results[1]->getResult());
        $this->assertEquals(39, $results[1]->getStart());
        $this->assertEquals(48, $results[1]->getEnd());
        $this->assertEquals(ProbeType::HASHTAG, $results[1]->getProbeType());
    }
}
