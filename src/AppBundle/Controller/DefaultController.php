<?php

namespace AppBundle\Controller;

use Psr\Http\Message\ResponseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) : Response
    {
        $sender = $this->get('app.sender');
		$request = new \GuzzleHttp\Psr7\Request('GET', 'https://github.com/');
        $gitHub = $sender->sendRequest($request, function (ResponseInterface $response) {
            return 'I completed! ' . $response->getBody();
        });

        return new Response($gitHub);
    }
}
