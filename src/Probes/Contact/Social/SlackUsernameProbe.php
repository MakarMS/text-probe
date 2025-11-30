<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class SlackUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![a-z0-9_@])'
            . '@'
            . '(?=.{2,32}\b)'
            . '(?!.*[.]{2})'
            . '(?!.*-{2})'
            . '(?!.*[.-]$)'
            . '(?!^[.-])'
            . '[a-z0-9](?:[a-z0-9._-]*[a-z0-9])?'
            . '(?=[\s.,!?]|$)/i',
            $text,
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SLACK_USERNAME;
    }
}
