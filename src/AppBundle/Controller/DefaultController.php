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
<<<<<<< HEAD
        $sender = $this->get('app.sender');
		$request = new \GuzzleHttp\Psr7\Request('GET', 'https://github.com/');
        $gitHub = $sender->sendRequest($request, function (ResponseInterface $response) {
            return 'I completed! ' . $response->getBody();
        });
        $parser = $this->get('app.parser');
        $title = $parser->parseContent($gitHub);
        return new Response($title);
=======
       return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/parse", name="app.parse-data")
     * @Method({"POST"})
     */
    public function parseAction(Request $request)
    {
        return dump($request);
//        $sender = $this->get('app.sender');
//        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://work.ua/');
//        $gitHub = $sender->sendRequest($request, function (ResponseInterface $response) {
//            return 'I completed! ' . $response->getBody();
//        });
//
//        return new Response($gitHub);
>>>>>>> 0a1b836bc7f53dbd7d119672058d3f35202539c1
    }
}
