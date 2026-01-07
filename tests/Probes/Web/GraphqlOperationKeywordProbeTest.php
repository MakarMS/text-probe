<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\GraphqlOperationKeywordProbe;

/**
 * @internal
 */
class GraphqlOperationKeywordProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new GraphqlOperationKeywordProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAPHQL_OPERATION_KEYWORD, $results[0]->getProbeType());
    }
    public function testUsesSample1(): void
    {
        $sample = array_values(self::validSamples())[0];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample2(): void
    {
        $sample = array_values(self::validSamples())[1];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample3(): void
    {
        $sample = array_values(self::validSamples())[2];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample4(): void
    {
        $sample = array_values(self::validSamples())[3];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample5(): void
    {
        $sample = array_values(self::validSamples())[4];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample6(): void
    {
        $sample = array_values(self::validSamples())[5];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample7(): void
    {
        $sample = array_values(self::validSamples())[6];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample8(): void
    {
        $sample = array_values(self::validSamples())[7];
        $this->testFindsMatches(...$sample);
    }

    public function testUsesSample9(): void
    {
        $sample = array_values(self::validSamples())[8];
        $this->testFindsMatches(...$sample);
    }



    public static function validSamples(): array
    {
        return [
            ['query'],
            ['mutation'],
            ['subscription'],
            ['query'],
            ['mutation'],
            ['subscription'],
            ['query'],
            ['mutation'],
            ['subscription'],
            ['query'],
        ];
    }
}
