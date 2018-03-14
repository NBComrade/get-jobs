<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use AppBundle\Entity\Job;
use AppBundle\Repository\SearchSettingRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class Parser implements ParserInterface
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var SearchSettingRepository
     */
    private $settingRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->entityManager = $entityManager;
    }

    public function parseContent(string $content)
    {
        $this->crawler->add($content);
        $repository= $this->entityManager->getRepository(SearchSettingRepository::class);
        $setting = $repository->getById(1); //todo inject EM
        $nodes = $this->crawler->filter($setting->cart)->each(function (Crawler $node) use ($setting) {
            $title =$node->filter($setting->title)->text();
            $href = $node->filter($setting->link)->attr('href');
            $company = $node->filter($setting->company)->text();
            return new Job($title, $company, $href);
        });
        return $nodes;
    }
}