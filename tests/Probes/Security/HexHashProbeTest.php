<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\HexHashProbe;

/**
 * @internal
 */
class HexHashProbeTest extends TestCase
{
    public function testDetectsMd5Hash(): void
    {
        $probe = new HexHashProbe();
        $text = 'MD5: d41d8cd98f00b204e9800998ecf8427e';

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame(ProbeType::HEX_HASH, $results[0]->getProbeType());
        $this->assertSame('d41d8cd98f00b204e9800998ecf8427e', $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(37, $results[0]->getEnd());
    }

    public function testDetectsSha1AndSha256Hashes(): void
    {
        $probe = new HexHashProbe();
        $sha1 = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $sha256 = '9e107d9d372bb6826bd81d3542a419d6e1f760fbc5ab5526a1c1261d6ae2a397';
        $text = sprintf('sha1=%s sha256=%s', $sha1, $sha256);

        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame([$sha1, $sha256], [$results[0]->getResult(), $results[1]->getResult()]);
    }

    public function testIgnoresInvalidOrShortHexStrings(): void
    {
        $probe = new HexHashProbe();
        $text = 'invalid hash g41d8cd98f00b204e9800998ecf8427e and short 12345abcde';

        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testDoesNotMatchFragmentsWithinLongerStrings(): void
    {
        $probe = new HexHashProbe();
        $text = 'xd41d8cd98f00b204e9800998ecf8427eff';

        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }

    public function testDetectsUppercaseHexStrings(): void
    {
        $probe = new HexHashProbe();
        $text = 'Hash: ABCDEFABCDEFABCDEFABCDEFABCDEFAB';

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame('ABCDEFABCDEFABCDEFABCDEFABCDEFAB', $results[0]->getResult());
    }
}
