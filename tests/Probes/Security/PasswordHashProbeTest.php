<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\PasswordHashProbe;

/**
 * @internal
 */
class PasswordHashProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Value: $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'Value: $argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PasswordHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'First $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 then $argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(72, $results[1]->getStart());
        $this->assertSame(120, $results[1]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'head $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(65, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Check $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(66, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PasswordHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234 and $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(65, $results[1]->getStart());
        $this->assertSame(125, $results[1]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = 'Prefix $argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA== suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PasswordHashProbe();

        $expectedFirst = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $expectedSecond = '$argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $text = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234, $argon2id$v=19$m=65536,t=2,p=1$YWJjZA==$YWJjZA==';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(60, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(62, $results[1]->getStart());
        $this->assertSame(110, $results[1]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PasswordHashProbe();

        $expected = '$2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $text = 'Value: $2y$10$abcdefghijklmnopqrstuvwxABCDEFGHIJKLMNOPQRSTUVWXY1234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(67, $results[0]->getEnd());
        $this->assertSame(ProbeType::PASSWORD_HASH, $results[0]->getProbeType());
    }
}
