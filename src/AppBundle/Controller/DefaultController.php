<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ParseData;
use AppBundle\Entity\SearchSetting;
use AppBundle\Form\ParseType;
use AppBundle\Form\SettingType;
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
        $form = $this->createForm(ParseType::class, $parseForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $jobs = $this->parse($data);
            return $this->render('default/show.html.twig', ['jobs' => $jobs]);
        }
        return $this->render('default/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/configure", name="app.configure")
     * @Method({"GET", "POST"})
     */
    public function configureAction(Request $request) : Response
    {
        $setting = new SearchSetting();
        $form = $this->createForm(SettingType::class, $setting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $setting = $form->getData();
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($setting);
             $entityManager->flush();
        }
        return $this->render('default/configure.html.twig', ['form' => $form->createView()]);
    }

    public function parse($data)
    {
        $sender = $this->get('app.sender');
        $parser = $this->get('app.parser');
        $url = $sender->configureUrl($data);
        $parseRequest = new \GuzzleHttp\Psr7\Request('GET', $url);
        $content = $sender->sendRequest($parseRequest, function (ResponseInterface $response) {
            return $response->getBody();
        });

        return $parser->parseContent($content);
    }
}
