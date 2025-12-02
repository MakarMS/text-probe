<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Result;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\NoopValidator;

/**
 * Base class for all text probes.
 *
 * A probe encapsulates the logic for extracting specific patterns from text.
 * It provides a shared regex-based extraction helper and optional validation
 * layer via {@see IValidator}, while concrete probes implement
 * {@see Probe::getProbeType()} to specify their probe type.
 */
abstract class Probe
{
    /**
     * Validator applied to each matched value to decide whether it should be
     * included in the final results.
     */
    protected IValidator $validator;

    /**
     * @param IValidator|null $validator Optional validator to apply additional
     *                                   checks or normalisation to detected
     *                                   matches. If null, {@see NoopValidator}
     *                                   is used and all matches are accepted.
     */
    public function __construct(?IValidator $validator = null)
    {
        $this->validator = $validator ?? new NoopValidator();
    }

    /**
     * Runs a regular expression against the given text and converts all matches
     * into {@see Result} objects.
     *
     * Offsets are calculated in characters (multibyte-safe) rather than bytes,
     * so they remain consistent with typical PHP string operations on UTF-8
     * text.
     *
     * @param string $regex PCRE pattern to search with (including delimiters
     *                      and any flags)
     * @param string $text  input text to analyze
     *
     * @return array<Result> list of validated results in the order they appear
     *                       in the input text
     */
    protected function findByRegex(string $regex, string $text): array
    {
        preg_match_all($regex, $text, $matches, PREG_OFFSET_CAPTURE);

        if (!isset($matches[0])) {
            return [];
        }

        $results = [];
        foreach ($matches[0] as [$match, $byteOffset]) {
            if (!$this->validator->validate($match)) {
                continue;
            }

            $charOffset = mb_strlen(substr($text, 0, $byteOffset));
            $charLength = mb_strlen($match);

            $results[] = new Result($this->getProbeType(), $match, $charOffset, $charOffset + $charLength);
        }

        return $results;
    }

    /**
     * Returns the probe type associated with this probe implementation.
     *
     * @return BackedEnum specific {@see ProbeType} enum value for this probe
     */
    abstract protected function getProbeType(): BackedEnum;
}
