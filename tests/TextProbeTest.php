<?php

namespace Tests;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Result;
use TextProbe\TextProbe;

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

        $this->assertIsArray($results);
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
}