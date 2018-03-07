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

        $nodes = $this->crawler->filter('.card.job-link')->each(function (Crawler $node, $i) {
            $title =$node->filter('h2 a')->attr('title');
            $href = $node->filter('h2 a')->attr('href');
            $company = $node->filter('div')->last()->filter('span')->first()->text();
            return [$title, $href, $company];
        });
        dump($nodes);
        return 'Hello';
    }
}