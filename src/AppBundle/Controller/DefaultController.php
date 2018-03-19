<?php

namespace AppBundle\Controller;

use AppBundle\DTO\JobQuery;
use AppBundle\Entity\SearchSetting;
use AppBundle\Form\ParseType;
use AppBundle\Form\SettingType;
use Psr\Http\Message\ResponseInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app.homepage")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request) : Response
    {
        $parseForm = new JobQuery();
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
     * @param Request $request
     * @return Response
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

    private function parse($data)
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

    /**
     * @Route("/add-favorite", name="app.add-favorite")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addFavoriteAction(Request $request) : JsonResponse
    {
        if($request->request->get('data')){
            //make something curious, get some unbelieveable data
            $arrData = ['output' => 'here the result which will appear in div'];
            return new JsonResponse($arrData);
        }
        return null;
    }
}
