<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class TelegramUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/@[a-zA-Z0-9_]{5,32}/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TELEGRAM_USERNAME;
    }
}