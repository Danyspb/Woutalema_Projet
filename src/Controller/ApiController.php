<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Moto;
use App\Repository\MotoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user_get", methods={"GET"})
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

    /**
     * @Route("/api/moto", name="api_moto_get", methods={"GET"})
     * @param MotoRepository $reposi
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function getmoto(MotoRepository $reposi, SerializerInterface $serializer): Response
    {
        $moto = $reposi->findAll();

        return $this->json($moto, 200, [], ['groups'=>'info:moto']);
    }

    /**
     * @Route("/api/moto/post", name="api_moto_insert", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function inject(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        $userget = $request->getContent();
        try {
            $moto = $serializer->deserialize($userget, Moto::class, 'json');
            $erreur = $validator->validate($moto);
            if (count($erreur)>0){
                return $this->json($erreur, 400);
            }
            $manager->persist($moto);
            $manager->flush();

            return $this->json($moto, 201, [], ['groups'=>'info:moto']);
        }catch (NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message' => $e->getMessage()
            ], 400);
        }


    }
}
