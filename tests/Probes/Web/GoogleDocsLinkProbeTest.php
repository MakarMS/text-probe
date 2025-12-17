<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\GoogleDocsLinkProbe;

/**
 * @internal
 */
class GoogleDocsLinkProbeTest extends TestCase
{
    public function testFindsDocumentLinks(): void
    {
        $probe = new GoogleDocsLinkProbe();

        $text = 'Check https://docs.google.com/document/d/1AbcD-12345/edit#heading=h.gjdgxs now.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://docs.google.com/document/d/1AbcD-12345/edit#heading=h.gjdgxs', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(74, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GOOGLE_DOCS_LINK, $results[0]->getProbeType());
    }

    public function testFindsSpreadsheetLinksWithQuery(): void
    {
        $probe = new GoogleDocsLinkProbe();

        $text = 'Spreadsheet: http://docs.google.com/spreadsheets/d/abcdEF12345/export?format=csv';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('http://docs.google.com/spreadsheets/d/abcdEF12345/export?format=csv', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(80, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GOOGLE_DOCS_LINK, $results[0]->getProbeType());
    }

    public function testFindsSlidesLinksWithoutTrailingPunctuation(): void
    {
        $probe = new GoogleDocsLinkProbe();

        $text = 'Slides link (https://docs.google.com/presentation/d/1-ABCdefGhIJkLmN0/edit?usp=sharing).';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://docs.google.com/presentation/d/1-ABCdefGhIJkLmN0/edit?usp=sharing', $results[0]->getResult());
        $this->assertEquals(13, $results[0]->getStart());
        $this->assertEquals(86, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GOOGLE_DOCS_LINK, $results[0]->getProbeType());
    }

    public function testFindsFormLinks(): void
    {
        $probe = new GoogleDocsLinkProbe();

        $text = 'Fill the form https://docs.google.com/forms/d/e/1FAIpQLSd12345/viewform?usp=sf_link today.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('https://docs.google.com/forms/d/e/1FAIpQLSd12345/viewform?usp=sf_link', $results[0]->getResult());
        $this->assertEquals(14, $results[0]->getStart());
        $this->assertEquals(83, $results[0]->getEnd());
        $this->assertEquals(ProbeType::GOOGLE_DOCS_LINK, $results[0]->getProbeType());
    }

    public function testIgnoresNonGoogleDocsDomains(): void
    {
        $probe = new GoogleDocsLinkProbe();

        $text = 'Broken link https://docs.example.com/document/d/1Abc/edit should be ignored.';
        $results = $probe->probe($text);

        $this->assertEmpty($results);
    }
}
