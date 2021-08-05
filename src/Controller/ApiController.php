<?php

namespace App\Controller;

use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user", methods={"GET"})
     * @param UserRepository $userRepos
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(UserRepository $userRepos, SerializerInterface $serializer): Response
    {
        $us = $userRepos->findAll();
        // transforme les donnees en tableau(normalisation)
        //$usernorm = $normalizer->normalize($us ,'json',['groups'=>'info:user']);
        //$json  = json_encode($usernorm);

        /*$json = $serializer->serialize($us,'json', ['groups'=>'info:user']);
        $response = new Response($json,200,[
            "Content-Type" => "application/json"
        ]);
        */

        //$response = new JsonResponse($json , 200,[], true);

        // methode de serialise en une seule ligne

        return $this->json($us, 200, [], ['groups'=>'info:user']);


    }
}
