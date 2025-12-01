<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts email addresses from text.
 *
 * This probe matches common email formats, including subdomains and plus-aliases,
 * while attempting to reduce obvious false positives where possible.
 */
class EmailProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EMAIL
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EMAIL;
    }
}
