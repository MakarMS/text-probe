<?php

namespace Tests\Probes\Software;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Software\ComposerPackageNameProbe;

/**
 * @internal
 */
class ComposerPackageNameProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ComposerPackageNameProbe();

        $expected = 'symfony/console';
        $text = 'Value: symfony/console';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPOSER_PACKAGE_NAME, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ComposerPackageNameProbe();

        $expected = 'symfony/console';
        $text = 'First symfony/console then symfony/console';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::COMPOSER_PACKAGE_NAME, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(27, $results[1]->getStart());
        $this->assertSame(42, $results[1]->getEnd());
        $this->assertSame(ProbeType::COMPOSER_PACKAGE_NAME, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new ComposerPackageNameProbe();

        $text = 'Value: symfony console';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new ComposerPackageNameProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new ComposerPackageNameProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
