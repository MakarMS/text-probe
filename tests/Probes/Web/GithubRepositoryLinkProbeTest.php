<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\GithubRepositoryLinkProbe;

/**
 * @internal
 */
class GithubRepositoryLinkProbeTest extends TestCase
{
    public function testExtractsStandardRepositoryLink(): void
    {
        $probe = new GithubRepositoryLinkProbe();

        $text = 'Repository: https://github.com/symfony/symfony';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('https://github.com/symfony/symfony', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(46, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GITHUB_REPOSITORY_LINK, $results[0]->getProbeType());
    }

    public function testSupportsWwwAndTrailingSlash(): void
    {
        $probe = new GithubRepositoryLinkProbe();

        $text = 'Fetch http://www.github.com/org/repo/ for docs.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('http://www.github.com/org/repo/', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(37, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GITHUB_REPOSITORY_LINK, $results[0]->getProbeType());
    }

    public function testMatchesLinksWithAdditionalPathsAndPunctuation(): void
    {
        $probe = new GithubRepositoryLinkProbe();

        $text = 'See https://github.com/org-name/repo_name.docs/issues/42).';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('https://github.com/org-name/repo_name.docs/issues/42', $results[0]->getResult());
        $this->assertEquals(4, $results[0]->getStart());
        $this->assertEquals(56, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GITHUB_REPOSITORY_LINK, $results[0]->getProbeType());
    }

    public function testDetectsGitSuffix(): void
    {
        $probe = new GithubRepositoryLinkProbe();

        $text = 'Clone from https://github.com/org/repo.git today.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('https://github.com/org/repo.git', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(42, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GITHUB_REPOSITORY_LINK, $results[0]->getProbeType());
    }

    public function testDoesNotMatchProfilesWithoutRepository(): void
    {
        $probe = new GithubRepositoryLinkProbe();

        $text = 'Profile https://github.com/owner is not a repository link.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
