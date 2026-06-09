<?php

namespace TextProbe;

use TextProbe\Probes\Contracts\IProbe;

/**
 * Main entry point for running multiple probes against a text.
 *
 * The TextProbe class acts as a container for probe instances. You can register
 * one or more probes via {@see addProbe()}, then call {@see analyze()} to run
 * all of them over the same input string and collect their results.
 */
class TextProbe
{
    /**
     * Registered probes that will be executed during analysis.
     *
     * @var IProbe[]
     */
    private array $probes = [];

    /**
     * Adds a probe to the internal list of probes to be executed.
     *
     * @param IProbe $probe probe instance to register
     */
    public function addProbe(IProbe $probe): void
    {
        $this->probes[] = $probe;
    }

    /**
     * Runs all registered probes against the given text and aggregates results.
     *
     * Probes are executed in the order they were added. All results are
     * collected into a single flat array without deduplication.
     *
     * @param string $text input text to analyze
     *
     * @return Result[] list of results from all probes
     */
    public function analyze(string $text): array
    {
        $results = [];

        foreach ($this->probes as $probe) {
            array_push($results, ...$probe->probe($text));
        }

        return $results;
    }

    /**
     * Replaces all non-overlapping matches found by registered probes.
     *
     * Replacement is applied to validated probe results using the character
     * offsets stored in {@see Result}.
     *
     * @param string $text        input text to transform
     * @param string $replacement literal replacement text
     */
    public function replace(string $text, string $replacement): string
    {
        $results = $this->analyze($text);

        if ($results === []) {
            return $text;
        }

        usort(
            $results,
            static fn (Result $left, Result $right): int => [
                $left->getStart(),
                $left->getEnd(),
            ] <=> [
                $right->getStart(),
                $right->getEnd(),
            ],
        );

        $replaced = '';
        $cursor = 0;

        foreach ($results as $result) {
            $start = $result->getStart();
            $end = $result->getEnd();

            if ($start < $cursor || $end < $start) {
                continue;
            }

            $replaced .= mb_substr($text, $cursor, $start - $cursor) . $replacement;
            $cursor = $end;
        }

        return $replaced . mb_substr($text, $cursor);
    }

    /**
     * Removes all registered probes.
     *
     * After calling this method, {@see analyze()} will return an empty result
     * set until new probes are added via {@see addProbe()}.
     */
    public function clean(): void
    {
        $this->probes = [];
    }
}
