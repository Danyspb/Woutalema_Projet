<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\LivreurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LivreurController extends AbstractController
{
    /**
     * @Route("/livreur", name="livreur")
     * @param Request $req
     * @param SessionInterface $session
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $req, SessionInterface $session,EntityManagerInterface $manager): Response
    {

        $livreur = new Livreur();
        $livreur_form = $this->createForm(LivreurType::class,$livreur);
        $livreur_form->handleRequest($req);
        if ($livreur_form->isSubmitted() && $livreur_form->isValid())

        {
            $user = $session->get('user');
            $user->setLivreur($livreur);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('livreur/index.html.twig', [
            'form' => $livreur_form->createView(),
        ]);
    }
}
