<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts JSON Web Tokens (JWT) in compact serialization form.
 *
 * This probe matches three Base64url-encoded segments separated by dots
 * (e.g. "xxxxx.yyyyy.zzzzz"), with optional padding, and uses lookarounds
 * to avoid partial matches inside longer alphanumeric strings.
 */
class JwtTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $seg = '[A-Za-z0-9_-]{2,}={0,2}';
        $jwt = $seg . '\.' . $seg . '\.' . $seg;

        $regex = '/(?<![A-Za-z0-9_-])(' . $jwt . ')(?=[\s.,;:!?)}\]\r\n\t])/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::JWT_TOKEN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JWT_TOKEN;
    }
}
