<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts absolute HTTP/HTTPS URLs.
 */
class AbsoluteHttpUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^https?:\/\/[A-Za-z0-9.-]+(?::\d{2,5})?(?:\/[\S]*)?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ABSOLUTE_HTTP_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ABSOLUTE_HTTP_URL;
    }
}
