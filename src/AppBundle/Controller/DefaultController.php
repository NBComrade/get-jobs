<?php

namespace AppBundle\Controller;

use Psr\Http\Message\ResponseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app.homepage")
     * @Method({"GET"})
     */
    public function indexAction(Request $request) : Response
    {
        $sender = $this->get('app.sender');
		$request = new \GuzzleHttp\Psr7\Request('GET', 'https://work.ua/');
        $gitHub = $sender->sendRequest($request, function (ResponseInterface $response) {
            return 'I completed! ' . $response->getBody();
        });

        return new Response($gitHub);
    }

    /**
     * @Route("/parse", name="app.parse-data")
     * @Method({"POST"})
     */
    public function parseAction(Request $request) : Response
    {
        dump($request);
    }
}
