<?php

namespace App\Controller;

use App\Entity\Scenario;
use App\Form\ScenarioType;
use App\Repository\ScenarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/scenario")
 */
class ScenarioControllerAPI extends AbstractController
{
    /**
     * @Route("/", name="scenario_index_api", methods={"GET"})
     */
    public function index(ScenarioRepository $scenarioRepository): Response
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $scenarios = $scenarioRepository->findAll();
        $jsonContent = $serializer->serialize($scenarios, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/new", name="scenario_new_api", methods={"GET", "POST","OPTIONS"})
     */
    public function new(Request $request): Response
    {
        $response = new Response();
        $query = array();
        $scenario = new Scenario();

        $json = $request->getContent();
        $content = json_decode($json, true);

        if (isset($content["name"]) && isset($content["gM"])) {
            $scenario->setName($content["name"]);
            $scenario->setGM($content["gM"]);
            $scenario->setDescription($content["description"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($scenario);
            $em->flush();

            $query['valid'] = true;
            $query['data'] = array(
                'description' => $content["description"],
                'gm' => $content["gM"],
                'mycharacters' => $content["mycharacters"],
                'name' => $content["name"]);
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
     * @Route("/{id}", name="scenario_show_api", methods="GET")
     */
     public function show(Scenario $scenario): Response
     {
         $encoders = array(new JsonEncoder());
         $normalizers = array(new ObjectNormalizer());
         $serializer = new Serializer($normalizers, $encoders);
         $jsonContent = $serializer->serialize($scenario, 'json');
         $response = new JsonResponse();
         $response->setContent($jsonContent);
         $response->headers->set('Content-Type', 'application/json');
         $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;
     }

     /**
      * @Route("/{id}/edit", name="scenario_edit_api", methods={"PUT", "OPTIONS"})
      */
     public function edit(Request $request, Scenario $scenario): Response
     {
         $response = new Response();
         $query = array();

         $json = $request->getContent();
         $content = json_decode($json, true);

         if (isset($content["name"]) && isset($content["name"])) {
             $scenario->setDescription($content["description"]);
             $scenario->setGM($content["gM"]);
             //add mycharacters
             $scenario->setName($content["name"]);
             $em = $this->getDoctrine()->getManager();
             $em->persist($scenario);
             $em->flush();

             $query['valid'] = true;
             $query['data'] = array(
                 'id' => $content["id"],
                 'description' => $content["description"],
                 'gm' => $content["gM"],
                 'mycharacters' => $content["mycharacters"],
                 'name' => $content["name"]);
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
      * @Route("/{id}", name="scenario_delete_api", methods={"DELETE", "OPTIONS"})
      */
     public function delete(Request $request, Scenario $scenario): Response
     {
         $response = new Response();
         $query = array();

         if ($scenario != null) {
             $em = $this->getDoctrine()->getManager();
             $em->remove($scenario);
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
