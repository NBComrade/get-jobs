<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use AppBundle\Entity\Job;
use AppBundle\Entity\SearchSetting;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class Parser implements ParserInterface
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var Sender
     */
    private $sender;
    /**
     * @array
     * Result of parsing
     */
    private $jobs = [];

    public function __construct(Crawler $crawler, EntityManager $entityManager, Sender $sender)
    {
        $this->crawler = $crawler;
        $this->entityManager = $entityManager;
        $this->sender = $sender;
    }

    public function parseContent(string $content)
    {
        $this->crawler->add($content);
        $repository= $this->entityManager->getRepository(SearchSetting::class);
        $setting = $repository->getById(1); //todo magic number must remove
        $nextLink = $this->crawler->filter('.nextbtn a');

        $nodes = $this->crawler->filter($setting->getCart())->each(function (Crawler $node) use ($setting) {
            $title =$node->filter($setting->getTitle())->text();
            $href = $node->filter($setting->getLink())->attr('href');
            $company = $node->filter($setting->getCompany())->text();
            $url = $setting->getDomain() . $href;
            return new Job($title, $company, $url);
        });
        $this->jobs = array_merge($this->jobs, $nodes);
        $this->crawler->clear(); // crawler need clear for recursive call
        if ($nextLink->count()) {
            $url = $setting->getDomain() . $nextLink->attr('href');
            $parseRequest = new \GuzzleHttp\Psr7\Request('GET', $url);
            $content = $this->sender->sendRequest($parseRequest, function (ResponseInterface $response) {
                return $response->getBody();
            });

            $this->parseContent($content);
        }
        return $this->jobs;
    }
}