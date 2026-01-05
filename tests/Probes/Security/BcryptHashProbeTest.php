<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\BcryptHashProbe;

/**
 * @internal
 */
class BcryptHashProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Value: $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $text = 'Value: $2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new BcryptHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $text = 'First $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 then $2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(72, $results[1]->getStart());
        $this->assertSame(132, $results[1]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'head $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Check $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new BcryptHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 and $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(65, $results[1]->getStart());
        $this->assertSame(125, $results[1]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $text = 'Prefix $2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new BcryptHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234, $2b$12$ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwx1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(122, $results[1]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new BcryptHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Value: $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::BCRYPT_HASH, $results[0]->getProbeType());
    }
}
