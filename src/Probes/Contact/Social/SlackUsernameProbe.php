<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Slack-style usernames (e.g. "@username").
 *
 * This probe applies Slack-specific rules for allowed characters, length limits,
 * and disallows invalid patterns such as consecutive dots or dashes, leading/trailing
 * punctuation and other malformed handles.
 */
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

    /**
     * @return ProbeType returns ProbeType::SLACK_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SLACK_USERNAME;
    }
}
