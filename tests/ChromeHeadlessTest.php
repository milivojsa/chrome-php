<?php

namespace ChromeHeadless\Test;

use PHPUnit\Framework\TestCase;
use ChromeHeadless\ChromeHeadless;
use ChromeHeadless\Exceptions\ChromeException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class ChromeHeadlessTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_the_html()
    {
        $html = ChromeHeadless::url('https://google.com')->getHtml();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_can_get_the_dom()
    {
        $crawler = ChromeHeadless::url('https://google.com')->getDOMCrawler();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_can_block_resource_type()
    {
        $this->expectException(ChromeException::class);

        $html = ChromeHeadless::url('https://example.com')
            ->setExcluded(['document'])
            ->getHtml();
    }

    /**
     * @test
     */
    public function it_can_set_and_detect_a_timeout()
    {
        $this->expectException(ProcessTimedOutException::class);

        ChromeHeadless::url('https://example.com')->setTimeout(0.01)->getHtml();
    }

    /**
     * @test
     */
    public function it_can_merge_blacklisted_or_excluded_property()
    {
        $headless = ChromeHeadless::url('https://example.com')
            ->setBlacklist(['blaclisted_1'])
            ->setExcluded(['excluded_1']);

        $headless->setBlacklist(['blacklist_2'])
            ->setExcluded(['excluded_2']);

        $this->assertContains('blaclisted_1', $headless->getBlacklist());
        $this->assertContains('excluded_1', $headless->getExcluded());
    }

    /**
     * @test
     */
    public function it_can_clean_set_blacklisted_or_excluded_property()
    {
        $headless = ChromeHeadless::url('https://example.com')
            ->setBlacklist(['blaclisted_1'])
            ->setExcluded(['excluded_1']);

        $headless->setBlacklist(['blacklist_2'], true)
            ->setExcluded(['excluded_2'], true);

        $this->assertNotContains('blaclisted_1', $headless->getBlacklist());
        $this->assertNotContains('excluded_1', $headless->getExcluded());
    }

    /**
     * @test
     */
    public function it_can_detect_an_unsuccessful_http_response()
    {
        $this->expectException(ChromeException::class);

        ChromeHeadless::url('https://httpstat.us/500')->getHtml();
    }

    /**
     * @test
     */
    public function it_can_detect_a_invalid_request()
    {
        $this->expectException(ChromeException::class);

        ChromeHeadless::url('https://thiswebsitedoesnotexistatall912393124.com')->getHtml();
    }
}
