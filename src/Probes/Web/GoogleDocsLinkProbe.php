<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts links to Google Docs resources.
 *
 * Supports document, spreadsheet, presentation, and form links hosted on
 * docs.google.com, including additional path segments and query parameters.
 */
class GoogleDocsLinkProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?:https?:\/\/)?docs\.google\.com\/(?:document\/d|spreadsheets\/d|presentation\/d|forms\/d\/e)\/[A-Za-z0-9_-]+(?:\/[^\s)]*)?(?<![.,;:!?\s])/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::GOOGLE_DOCS_LINK
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GOOGLE_DOCS_LINK;
    }
}
