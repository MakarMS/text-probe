<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\HuggingFaceTokenProbe;

/**
 * @internal
 */
class HuggingFaceTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_abcdefghijklmnopqrstuvwxyz';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'hf_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $first = 'hf_abcdefghijklmnopqrstuvwxyz';
        $second = 'hf_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz' . "\n" . 'hf_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(30, $results[1]->getStart());
        $this->assertSame(65, $results[1]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_abcdefghijklmnopqrstuvwxyz';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_abcdefghijklmnopqrstuvwxyz';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_abcdefghijklmnopqrstuvwxyz';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $text = 'hf_short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new HuggingFaceTokenProbe();

        $expected = 'hf_abcdefghijklmnopqrstuvwxyz';
        $text = 'hf_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(29, $results[0]->getEnd());
        $this->assertSame(ProbeType::HUGGING_FACE_TOKEN, $results[0]->getProbeType());
    }
}
