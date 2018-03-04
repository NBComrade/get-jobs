<?php

namespace AppBundle\Contract;

use Psr\Http\Message\RequestInterface;

interface SenderInterface
{
    public function sendRequest(RequestInterface $request, callable $handler);
}