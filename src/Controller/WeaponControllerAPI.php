<?php

namespace App\Controller;

use App\Entity\Weapon;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/weapon")
 */
class WeaponControllerAPI extends AbstractController
{
    /**
     * @Route("/", name="weapon_index_api", methods={"GET"})
     */
    public function index(WeaponRepository $weaponRepository): Response
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $weapons = $weaponRepository->findAll();
        $jsonContent = $serializer->serialize($weapons, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("/new", name="weapon_new_api", methods={"GET|POST"})
     */
    public function new(Request $request): Response
    {
        $response = new Response();
        $query = array();
        $weapon = new Weapon();

        $json = $request->getContent();
        $content = json_decode($json, true);

        if (isset($content["name"]) && isset($content["damage"])) {
            $weapon->setName($content["name"]);
            $weapon->setDamage($content["damage"]);
            $weapon->setFKMycharacter($content["fKMycharacter"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($weapon);
            $em->flush();

            $query['valid'] = true;
            $query['data'] = array(
                'name' => $content["name"],
                'damage' => $content["damage"],
                'fKMycharacter' => $content["fKMycharacter"]);
        }

        else {
            $query['valid'] = false;
            $query['data'] = null;
        }

        $response->setContent(json_encode($query));
        return $response;
    }

    /**
     * @Route("/{id}", name="weapon_show_api", methods={"GET"})
     */
    public function show(Weapon $weapon): Response
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($weapon, 'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("/{id}/edit", name="weapon_edit_api", methods={"PUT"})
     */
    public function edit(Request $request, Weapon $weapon): Response
    {
        $response = new Response();
        $query = array();

        $json = $request->getContent();
        $content = json_decode($json, true);

        if (isset($content["name"]) && isset($content["damage"])) {
            $weapon->setName($content["name"]);
            $weapon->setDamage($content["damage"]);                $weapon->setFKMycharacter($content["fKMycharacter"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($weapon);
            $em->flush();

            $query['valid'] = true;
            $query['data'] = array(
                'id' => $content["id"],
                'name' => $content["name"],
                'damage' => $content["damage"],
                'fKMycharacter' => $content["fKMycharacter"]);
        }

        else {
            $query['valid'] = false;
            $query['data'] = null;
            $query['test_name'] = $content["name"];
            $query['test_damage'] = $content["damage"];
            $query['test_fKMycharacter'] = $content["fKMycharacter"];
        }
        $response->setContent(json_encode($query));
        return $response;
    }

    /**
     * @Route("/{id}", name="weapon_delete_api", methods={"DELETE"})
     */
    public function delete(Request $request, Weapon $weapon): Response
    {
        $response = new Response();
        $query = array();

        if ($weapon != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($weapon);
            $em->flush();
            $query['valid'] = true;
        }

        else {
            $query['valid'] = false;
        }
        $response->setContent(json_encode($query));
        return $response;
    }
}
