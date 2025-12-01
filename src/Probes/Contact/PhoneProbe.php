<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts phone numbers from text.
 *
 * This probe supports multiple international and local formats, including optional
 * country codes, brackets, spaces and dashes between digit groups, while trying to
 * avoid obvious false positives inside longer numeric sequences.
 */
class PhoneProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:\+?\d{1,3}[\s-]?)?\(?\d{2,4}\)?[\s-]?(?:\d{2,4}[\s-]?){2,4}(?=\s|$|\W)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::PHONE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PHONE;
    }
}
