<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ParseData;
use AppBundle\Form\ParseForm;
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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) : Response
    {
        $parseForm = new ParseData();
        $form = $this->createForm(ParseForm::class, $parseForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data= $form->getData();
        }
        return $this->render('default/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/parse", name="app.parse-data")
     */
    public function parseAction(Request $request)
    {
        $sender = $this->get('app.sender');
        $searchQuery = $request->get('search');
        $city = $request->get('city');
        //selector .card.job-link
        $queryString = 'jobs-' . $city . '-' . $searchQuery;
        $parseRequest = new \GuzzleHttp\Psr7\Request('GET', 'https://work.ua/' . $queryString);
        $content = $sender->sendRequest($parseRequest, function (ResponseInterface $response) {
            return $response->getBody();
        });
        $parser = $this->get('app.parser');
        $gitHub = $parser->parseContent($content);

        return new Response($gitHub);
    }
}
