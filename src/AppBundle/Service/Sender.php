<?php

namespace AppBundle\Service;

use AppBundle\Contract\SenderInterface;
use AppBundle\Entity\ParseData;
use AppBundle\Entity\SearchSetting;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Sender implements SenderInterface
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(ClientInterface $client, EntityManager $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function sendRequest(RequestInterface $request, callable $handler)
    {
        $promise = $this->client->sendAsync($request)->then($handler);
        return $promise->wait();
    }

    public function configureUrl(ParseData $data)
    {
        $repository = $this->entityManager->getRepository(SearchSetting::class);
        $pattern = $repository->getDomainWithQuery(1);
        return sprintf($pattern, $data->getCity(), $data->getQuery(), $data->getDays());
    }
}