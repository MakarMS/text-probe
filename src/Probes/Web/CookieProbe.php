<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Web\CookieValidator;

/**
 * Probe that extracts HTTP cookies (key=value pairs) from text.
 *
 * It detects cookie assignments in both `Set-Cookie` and `Cookie` headers, as
 * well as standalone cookie fragments. Cookie names follow RFC token rules and
 * values may be unquoted or quoted strings; common cookie attributes such as
 * `Path` or `Expires` are filtered out by the validator.
 */
class CookieProbe extends Probe implements IProbe
{
    public function __construct(?CookieValidator $validator = null)
    {
        parent::__construct($validator ?? new CookieValidator());
    }

    public function probe(string $text): array
    {
        $pattern = "/\\b(?:Set-Cookie:\\s*|Cookie:\\s*)?[!#$%&'*+.^_`|~0-9A-Za-z-]{1,128}=(\"[^\"]*\"|[!#$%&'*+.^_`|~0-9A-Za-z-]{1,2048})/i";

        return $this->findByRegex($pattern, $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_COOKIE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_COOKIE;
    }
}
