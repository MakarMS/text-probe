<?php

namespace TextProbe;

use BackedEnum;

/**
 * Immutable value object that represents a single probe match.
 *
 * Each instance stores:
 * - the probe type that produced the match,
 * - the matched substring,
 * - the start and end character offsets within the original text.
 */
class Result
{
    /**
     * Probe type that produced this result (e.g. a specific ProbeType enum value).
     */
    private BackedEnum $probeType;

    /**
     * Matched substring from the analyzed text.
     */
    private string $result;

    /**
     * Zero-based start offset (in characters) of the match in the original text.
     */
    private int $start;

    /**
     * Zero-based end offset (in characters) of the match in the original text.
     */
    private int $end;

    /**
     * @param BackedEnum $probeType probe type associated with this match
     * @param string     $result    matched substring
     * @param int        $start     start character offset of the match
     * @param int        $end       end character offset of the match
     */
    public function __construct(BackedEnum $probeType, string $result, int $start, int $end)
    {
        $this->probeType = $probeType;
        $this->result = $result;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Returns the probe type that produced this result.
     *
     * @return BackedEnum probe type enum value
     */
    public function getProbeType(): BackedEnum
    {
        return $this->probeType;
    }

    /**
     * Returns the matched substring.
     *
     * @return string extracted value from the original text
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * Returns the zero-based start offset of the match (in characters).
     *
     * @return int start position of the match
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * Returns the zero-based end offset of the match (in characters).
     *
     * @return int end position of the match
     */
    public function getEnd(): int
    {
        return $this->end;
    }
}
