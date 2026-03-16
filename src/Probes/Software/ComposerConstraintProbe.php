<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Software\ComposerConstraintTokenizerValidator;

/**
 * Probe that extracts Composer constraint strings from text.
 */
class ComposerConstraintProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional custom validator for constraint strings
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new ComposerConstraintTokenizerValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        $version = 'v?\d+\.\d+\.\d+(?:-[0-9A-Za-z.-]+)?(?:\+[0-9A-Za-z.-]+)?';
        $operator = '(?:\^|~|>=|<=|>|<|=)';
        $segment = '(?:' . $operator . '?\s*' . $version . '|\*)';

        $regex = '/(?<!\S)'
            . $segment
            . '(?:\s*(?:\|\||,)\s*' . $segment . '|\s+' . $segment . ')*'
            . '(?!\S)/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::COMPOSER_CONSTRAINT
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::COMPOSER_CONSTRAINT;
    }
}
