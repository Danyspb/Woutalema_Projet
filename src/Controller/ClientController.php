<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     * @param Request $req
     * @param SessionInterface $session
     * @param EntityManagerInterface $man
     * @return Response
     */
    public function index(Request $req ,SessionInterface $session , EntityManagerInterface $man): Response
    {
        $client = new Client();
        $client_form = $this->createForm(ClientType::class,$client);
        $client_form->handleRequest($req);
        if ($client_form->isSubmitted() && $client_form->isValid())
        {

            $man->persist($client);
            $user = $session->get('user');
            $user->setClient($client);
            $man->persist($user);
            $man->flush();
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('client/index.html.twig', [
            'form' => $client_form->createView(),
        ]);
    }
}
