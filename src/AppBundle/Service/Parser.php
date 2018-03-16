<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use AppBundle\DTO\Job;
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

    public function parseContent(string $content, $id = 1) //todo magic number must remove
    {
        $this->crawler->add($content);
        $setting = $this->configureCurrentSetting($id);
        $nextLink = $this->crawler->filter($setting->getNext());

        $nodes = $this->crawler->filter($setting->getCart())->each(function (Crawler $node) use ($setting) {
            return $this->parseSingleCart($node, $setting);
        });

        $this->jobs = array_merge($this->jobs, $nodes);

        if ($nextLink->count()) {
            $this->crawler->clear(); // crawler need clear for recursive call
            $url = $setting->getDomain() . $nextLink->attr('href');
            $this->parseContentRecursive($url);
        }

        return $this->jobs;
    }

    protected function parseSingleCart(Crawler $node, SearchSetting $setting) : Job
    {
        $title =$node->filter($setting->getTitle())->text();
        $href = $node->filter($setting->getLink())->attr('href');
        $company = $node->filter($setting->getCompany())->text();
        $image = $this->parseImage($node->filter($setting->getImage()));
        $date = $this->parseDate($node->filter($setting->getDate()));
        $url = $setting->getDomain() . $href;
        return new Job($title, $company, $url, $date, $image);
    }

    protected function parseContentRecursive(string $url)
    {
        $parseRequest = new \GuzzleHttp\Psr7\Request('GET', $url);
        $content = $this->sender->sendRequest($parseRequest, function (ResponseInterface $response) {
            return $response->getBody();
        });

        $this->parseContent($content);
    }

    protected function configureCurrentSetting(int $id)
    {
        $repository= $this->entityManager->getRepository(SearchSetting::class);
        return $repository->getById($id);
    }

    protected function parseImage(Crawler $node)
    {
        if ($node->count()) {
            return $node->attr('src');
        }
        return null;
    }

    protected function parseDate(Crawler $node)
    {
        if ($node->count()) {
            return $node->text();
        }
        return null;
    }
}