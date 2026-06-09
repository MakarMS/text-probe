<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google Cloud Pub/Sub topic resource names.
 *
 * Examples:
 * - valid: `projects/my-project-123/topics/events`
 * - valid: `projects/prod123456/topics/audit.logs`
 *
 * Constraints:
 * - Matches `projects/{project}/topics/{topic}` with the same project-id shape as `GcpProjectIdProbe` and topic names starting with a letter. It does not verify topic existence, IAM permissions, or reserved topic-name rules beyond the regex.
 * - Uses regex pattern `#\bprojects/[a-z][a-z0-9-]{4,28}[a-z0-9]/topics/[A-Za-z][A-Za-z0-9._~-]{2,254}\b#`.
 * - Relies on regex filtering only (no additional validator).
 */
class GcpPubSubTopicProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('#\\bprojects/[a-z][a-z0-9-]{4,28}[a-z0-9]/topics/[A-Za-z][A-Za-z0-9._~-]{2,254}\\b#', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GCP_PUBSUB_TOPIC
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GCP_PUBSUB_TOPIC;
    }
}
