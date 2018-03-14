<?php
namespace AppBundle\Service;

use AppBundle\Contract\ParserInterface;
use AppBundle\Entity\Job;
use AppBundle\Repository\SearchSettingRepository;
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

    public function __construct(Crawler $crawler, SearchSettingRepository $settingRepository)
    {
        $this->crawler = $crawler;
        $this->settingRepository = $settingRepository;
    }

    public function parseContent(string $content)
    {
        $this->crawler->add($content);
        $setting = $this->settingRepository->getById(1);
        $nodes = $this->crawler->filter($setting->cart)->each(function (Crawler $node) use ($setting) {
            $title =$node->filter($setting->title)->text();
            $href = $node->filter($setting->link)->attr('href');
            $company = $node->filter($setting->company)->text();
            return new Job($title, $company, $href);
        });
        return $nodes;
    }
}