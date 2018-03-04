<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use Symfony\Component\DomCrawler\Crawler;

class Parser implements ParserInterface
{
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function parseContent(string $content)
    {
        $this->crawler->add($content);
        return trim($this->crawler->filter('h1')->text());
    }
}