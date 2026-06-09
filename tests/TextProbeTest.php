<?php

namespace Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contact\EmailProbe;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Result;
use TextProbe\TextProbe;

/**
 * @internal
 */
class TextProbeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testAnalyzeWithProbe(): void
    {
        $probe = new TextProbe();
        $mock = $this->createMock(IProbe::class);

        $expected = new Result(ProbeType::EMAIL, 'email', 0, 0);
        $mock->method('probe')->willReturn([$expected]);

        $probe->addProbe($mock);
        $results = $probe->analyze('email');

        $this->assertCount(1, $results);
        $this->assertEquals($expected, $results[0]);
    }

    public function testAnalyzeWithoutProbes(): void
    {
        $probe = new TextProbe();
        $results = $probe->analyze('some text');

        $this->assertEmpty($results);
    }

    /**
     * @throws Exception
     */
    public function testCleanRemovesProbes(): void
    {
        $probe = new TextProbe();
        $mock = $this->createMock(IProbe::class);

        $expected = new Result(ProbeType::EMAIL, 'email', 0, 0);
        $mock->method('probe')->willReturn([$expected]);

        $probe->addProbe($mock);

        $resultsBefore = $probe->analyze('email');
        $this->assertEquals([$expected], $resultsBefore);

        $probe->clean();

        $resultsAfter = $probe->analyze('email');
        $this->assertEmpty($resultsAfter);
    }

    public function testReplaceSingleProbeMatch(): void
    {
        $probe = new TextProbe();
        $probe->addProbe(new EmailProbe());

        $result = $probe->replace('Contact test@example.com today.', '[email]');

        $this->assertSame('Contact [email] today.', $result);
    }

    public function testReplaceMultipleProbeMatches(): void
    {
        $probe = new TextProbe();
        $probe->addProbe(new EmailProbe());

        $result = $probe->replace('Send to one@example.com and two@example.org.', '[email]');

        $this->assertSame('Send to [email] and [email].', $result);
    }

    public function testReplacePreservesOriginalTextWhenProbeFindsNothing(): void
    {
        $probe = new TextProbe();
        $probe->addProbe(new EmailProbe());

        $result = $probe->replace('This text has no email.', '[email]');

        $this->assertSame('This text has no email.', $result);
    }

    public function testReplacePreservesUtf8TextAroundMatches(): void
    {
        $probe = new TextProbe();
        $probe->addProbe(new EmailProbe());

        $result = $probe->replace('Привет test@example.com, до связи.', '[email]');

        $this->assertSame('Привет [email], до связи.', $result);
    }

    /**
     * @throws Exception
     */
    public function testReplaceUsesAllRegisteredProbes(): void
    {
        $probe = new TextProbe();
        $emailProbe = $this->createMock(IProbe::class);
        $domainProbe = $this->createMock(IProbe::class);

        $emailProbe->method('probe')->willReturn([
            new Result(ProbeType::EMAIL, 'abc', 0, 3),
        ]);
        $domainProbe->method('probe')->willReturn([
            new Result(ProbeType::DOMAIN, 'ef', 4, 6),
        ]);

        $probe->addProbe($emailProbe);
        $probe->addProbe($domainProbe);

        $result = $probe->replace('abcdef', '[x]');

        $this->assertSame('[x]d[x]', $result);
    }

    public function testReplaceWithoutRegisteredProbesReturnsOriginalText(): void
    {
        $probe = new TextProbe();

        $result = $probe->replace('test@example.com', '[email]');

        $this->assertSame('test@example.com', $result);
    }

    /**
     * @throws Exception
     */
    public function testReplaceSkipsOverlappingProbeResults(): void
    {
        $probe = new TextProbe();
        $mock = $this->createMock(IProbe::class);

        $mock->method('probe')->willReturn([
            new Result(ProbeType::EMAIL, 'abc', 0, 3),
            new Result(ProbeType::DOMAIN, 'bcd', 1, 4),
            new Result(ProbeType::LINK, 'ef', 4, 6),
        ]);

        $probe->addProbe($mock);

        $result = $probe->replace('abcdef', '[x]');

        $this->assertSame('[x]d[x]', $result);
    }
}
