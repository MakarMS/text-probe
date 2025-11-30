<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Result;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\NoopValidator;

abstract class Probe
{
    protected IValidator $validator;

    public function __construct(?IValidator $validator = null)
    {
        $this->validator = $validator ?? new NoopValidator();
    }

    /** @return array<Result> */
    protected function findByRegex(string $regex, string $text): array
    {
        preg_match_all($regex, $text, $matches, PREG_OFFSET_CAPTURE);

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

    abstract protected function getProbeType(): BackedEnum;
}
