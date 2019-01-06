<?php

namespace App\Controller;

use App\Entity\Mycharacter;
use App\Entity\Weapon;
use App\Form\MycharacterType;
use App\Repository\MycharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/mycharacter")
 */
class MycharacterControllerAPI extends AbstractController
{
    /**
     * @Route("/index", name="mycharacter_index_api", methods={"GET"})
     */
    public function index(MycharacterRepository $mycharacterRepository): Response
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $mycharacters = $mycharacterRepository->findAll();
        $jsonContent = $serializer->serialize($mycharacters, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/new", name="mycharacter_new_api", methods={"GET", "POST","OPTIONS"})
     */
    public function new(Request $request): Response
    {
        $response = new Response();
        $query = array();
        $mycharacter = new Mycharacter();

        $json = $request->getContent();
        $content = json_decode($json, true);

        if (isset($content["name"]) &&
            isset($content["STR"]) &&
            isset($content["WIS"]) &&
            isset($content["DEX"])) {
            $mycharacter->setName($content["name"]);
            $mycharacter->setSTR($content["STR"]);
            $mycharacter->setWIS($content["WIS"]);
            $mycharacter->setDEX($content["DEX"]);
            //compute Health and MaxHealth
            foreach($content["weapon"] as $weapon) {
                $mycharacter.addWeapon($weapon);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($mycharacter);
            $em->flush();

            $query['valid'] = true;
            $query['data'] = array(
                'name' => $content["name"],
                'STR' => $content["STR"],
                'WIS' => $content["WIS"],
                'DEX' => $content["DEX"],
                'weapon' => $content["weapon"]
            );
        }

        else {
            $query['valid'] = false;
            $query['data'] = null;
        }

        $response->setContent(json_encode($query));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, OPTIONS, POST");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
        return $response;
    }

    /**
     * @Route("/{id}", name="mycharacter_show_api", methods={"GET"})
     */
    public function show(Mycharacter $mycharacter): Response
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($mycharacter, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/{id}/edit", name="mycharacter_edit_api", methods={"PUT", "OPTIONS"})
     */
    public function edit(Request $request, Mycharacter $mycharacter): Response
    {
        $response = new Response();
        $query = array();

        $json = $request->getContent();
        $content = json_decode($json, true);

        if (isset($content["name"]) &&
            isset($content["STR"]) &&
            isset($content["WIS"]) &&
            isset($content["DEX"])) {
            $mycharacter->setName($content["name"]);
            $mycharacter->setSTR($content["STR"]);
            $mycharacter->setWIS($content["WIS"]);
            $mycharacter->setDEX($content["DEX"]);
            //compute Health and MaxHealth
            foreach($content["weapon"] as $weapon) {
                $mycharacter.addWeapon($weapon);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($mycharacter);
            $em->flush();

            $query['valid'] = true;
            $query['data'] = array(
                'name' => $content["name"],
                'STR' => $content["STR"],
                'WIS' => $content["WIS"],
                'DEX' => $content["DEX"],
                'weapon' => $content["weapon"]
            );
        }

        else {
            $query['valid'] = false;
            $query['data'] = null;
        }

        $response->setContent(json_encode($query));
        $response->headers->set('Content-Type', 'application/text');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, OPTIONS, PUT");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
        return $response;
    }

    /**
     * @Route("/{id}", name="mycharacter_delete_api", methods={"DELETE", "OPTIONS"})
     */
    public function delete(Request $request, Mycharacter $mycharacter): Response
    {
        $response = new Response();
        $query = array();

        if ($mycharacter != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mycharacter);
            $em->flush();
            $query['valid'] = true;
        }

        else {
            $query['valid'] = false;
        }
        $response->setContent(json_encode($query));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", "GET, OPTIONS, DELETE");
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
        return $response;
    }
}
