<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\MarkdownImageProbe;

/**
 * @internal
 */
class MarkdownImageProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MarkdownImageProbe();

        $expected = '![logo](https://example.com/logo.png)';
        $text = 'Value: ![logo](https://example.com/logo.png)';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::MARKDOWN_IMAGE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MarkdownImageProbe();

        $expected = '![logo](https://example.com/logo.png)';
        $text = 'First ![logo](https://example.com/logo.png) then ![logo](https://example.com/logo.png)';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::MARKDOWN_IMAGE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(49, $results[1]->getStart());
        $this->assertSame(86, $results[1]->getEnd());
        $this->assertSame(ProbeType::MARKDOWN_IMAGE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new MarkdownImageProbe();

        $text = 'Value: [logo](https://example.com/logo.png)';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new MarkdownImageProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new MarkdownImageProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
