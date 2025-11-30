<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class PhoneProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:\+?\d{1,3}[\s-]?)?\(?\d{2,4}\)?[\s-]?(?:\d{2,4}[\s-]?){2,4}(?=\s|$|\W)/',
            $text,
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PHONE;
    }
}
