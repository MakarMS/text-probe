<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Xml Tag values from text.
 *
 * Examples:
 * - valid: `<note><to>x</to></note>`
 * - invalid: `xml text`
 *
 * Constraints:
 * - Uses a regex that accepts paired tags and self-closing tags.
 * - Relies on regex filtering only (no additional validator).
 */
class XmlTagProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<([A-Za-z_][A-Za-z0-9_.:-]*)(?:\s+[^>]*)?>.*?</\1>|<([A-Za-z_][A-Za-z0-9_.:-]*)(?:\s+[^>]*)?\s*/>~s', $text);
    }

    /**
     * @return ProbeType returns ProbeType::XML_TAG
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::XML_TAG;
    }
}
