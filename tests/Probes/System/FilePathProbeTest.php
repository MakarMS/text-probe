<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\FilePathProbe;

/**
 * @internal
 */
class FilePathProbeTest extends TestCase
{
    public function testDetectsLinuxAbsolutePath(): void
    {
        $probe = new FilePathProbe();

        $text = 'Config at /etc/passwd for demo.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('/etc/passwd', $results[0]->getResult());
        $this->assertSame(10, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[0]->getProbeType());
    }

    public function testDetectsWindowsAbsolutePath(): void
    {
        $probe = new FilePathProbe();

        $text = 'Located at C:\\Windows\\System32\\drivers\\etc\\hosts file.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('C:\\Windows\\System32\\drivers\\etc\\hosts', $results[0]->getResult());
        $this->assertSame(11, $results[0]->getStart());
        $this->assertSame(48, $results[0]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[0]->getProbeType());
    }

    public function testDetectsMultiplePathsInMixedText(): void
    {
        $probe = new FilePathProbe();

        $text = 'Paths: /usr/local/bin and C:\\Program Files\\App\\app.exe found.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame('/usr/local/bin', $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[0]->getProbeType());

        $this->assertSame('C:\\Program Files\\App\\app.exe', $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(54, $results[1]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[1]->getProbeType());
    }

    public function testRejectsRelativeAndMalformedPaths(): void
    {
        $probe = new FilePathProbe();

        $text = 'Relative etc/passwd and malformed C:Windows\\System32 not paths.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testMatchesPathsAdjacentToPunctuation(): void
    {
        $probe = new FilePathProbe();

        $text = 'Check(/var/log/syslog),then see C:\\Logs\\app.log!';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame('/var/log/syslog', $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[0]->getProbeType());

        $this->assertSame('C:\\Logs\\app.log', $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(47, $results[1]->getEnd());
        $this->assertSame(ProbeType::FILE_PATH, $results[1]->getProbeType());
    }
}
