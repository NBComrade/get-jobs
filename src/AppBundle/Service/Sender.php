<?php

namespace AppBundle\Service;

use AppBundle\Contract\SenderInterface;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Sender implements SenderInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendRequest(RequestInterface $request, callable $handler)
    {
        $promise = $this->client->sendAsync($request)->then($handler);
        return $promise->wait();
    }
}