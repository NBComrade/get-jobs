<?php

namespace AppBundle\Controller;

use Psr\Http\Message\ResponseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) : Response
    {
		$client = new \GuzzleHttp\Client();

		$request = new \GuzzleHttp\Psr7\Request('GET', 'https://github.com/');
        $anotherRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://medium.com/');

        // Send an asynchronous request.
		$gitHubPromise = $client->sendAsync($request)->then(function (ResponseInterface $response) {
             return 'I completed! ' . $response->getBody();
        });
		$gitHub = $gitHubPromise->wait();


        $mediumPromise = $client->sendAsync($anotherRequest)->then(function (ResponseInterface $response) {
            return $response->getBody();
        });
        $medium = $mediumPromise->wait();

        return new Response($gitHub . $medium);
    }
}
