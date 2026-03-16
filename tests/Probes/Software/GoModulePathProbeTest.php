<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\GoModulePathProbe;

/**
 * @internal
 */
class GoModulePathProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GoModulePathProbe();

        $expected = 'github.com/user/project';
        $text = 'Value: github.com/user/project';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::GO_MODULE_PATH, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GoModulePathProbe();

        $expected = 'github.com/user/project';
        $text = 'First github.com/user/project then github.com/user/project';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::GO_MODULE_PATH, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(35, $results[1]->getStart());
        $this->assertSame(58, $results[1]->getEnd());
        $this->assertSame(ProbeType::GO_MODULE_PATH, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GoModulePathProbe();

        $text = 'Value: github user project';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GoModulePathProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GoModulePathProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
