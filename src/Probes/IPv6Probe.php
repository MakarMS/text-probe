<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class IPv6Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![0-9a-f:])' .
            '((' .
            '(([0-9A-Fa-f]{1,4}:){6}|::([0-9A-Fa-f]{1,4}:){0,5})' .
            '(' .
            '(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])\.' .
            '(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])\.' .
            '(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])\.' .
            '(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])' .
            '))' .
            '|' .
            '((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|' .
            '(([0-9A-Fa-f]{1,4}:){1,7}:)|' .
            '(([0-9A-Fa-f]{1,4}:){1,6}:[0-9A-Fa-f]{1,4})|' .
            '(([0-9A-Fa-f]{1,4}:){1,5}(:[0-9A-Fa-f]{1,4}){1,2})|' .
            '(([0-9A-Fa-f]{1,4}:){1,4}(:[0-9A-Fa-f]{1,4}){1,3})|' .
            '(([0-9A-Fa-f]{1,4}:){1,3}(:[0-9A-Fa-f]{1,4}){1,4})|' .
            '(([0-9A-Fa-f]{1,4}:){1,2}(:[0-9A-Fa-f]{1,4}){1,5})|' .
            '([0-9A-Fa-f]{1,4}:((:[0-9A-Fa-f]{1,4}){1,6}))|' .
            '(:((:[0-9A-Fa-f]{1,4}){1,7}|:))' .
            ')' .
            ')' .
            '(?:%\S+)?' .
            '(?![0-9a-f:])/i',
            $text
        );
    }


    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IPV6;
    }
}
