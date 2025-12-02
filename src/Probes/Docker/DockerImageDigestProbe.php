<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker image digests from text.
 *
 * Supports canonical forms used in Docker registries, CLI output,
 * logs and SBOM metadata:
 *
 *   image@sha256:<64-hex>
 *   sha256:<64-hex>
 *
 * The probe always returns only the digest part (sha256:<64-hex>),
 * ignoring any optional image prefix before the '@'. It matches only
 * valid SHA256 digests (exactly 64 lowercase hex characters), ignoring
 * shorter, uppercase or non-hex variants.
 */
class DockerImageDigestProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?:[A-Za-z0-9._\/-]+@)?\Ksha256:[a-f0-9]{64}/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_IMAGE_DIGEST
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_IMAGE_DIGEST;
    }
}
