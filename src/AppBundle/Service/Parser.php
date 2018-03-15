<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use AppBundle\Entity\Job;
use AppBundle\Entity\SearchSetting;
use Doctrine\ORM\EntityManager;
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

    public function __construct(Crawler $crawler, EntityManager $entityManager)
    {
        $this->crawler = $crawler;
        $this->entityManager = $entityManager;
    }

    public function parseContent(string $content)
    {
        $this->crawler->add($content);
        $repository= $this->entityManager->getRepository(SearchSetting::class);
        $setting = $repository->getById(1); //todo magic number must remove
        $nodes = $this->crawler->filter($setting->getCart())->each(function (Crawler $node) use ($setting) {
            $title =$node->filter($setting->getTitle())->text();
            $href = $node->filter($setting->getLink())->attr('href');
            $company = $node->filter($setting->getCompany())->text();
            $url = $setting->getDomain() . $href;
            return new Job($title, $company, $url);
        });
        return $nodes;
    }
}