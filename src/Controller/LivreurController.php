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
     * @param SessionInterface $session
     * @param EntityManagerInterface $man
     * @param Request $request
     * @return Response
     */
    public function index(SessionInterface $session,EntityManagerInterface $man, Request $request): Response
    {
        $livreur = new Livreur();
        $livreur_form = $this->createForm(LivreurType::class,$livreur);
        $livreur_form->handleRequest($request);
        if ($livreur_form->isSubmitted() && $livreur_form->isSubmitted())
        {
            $man->persist($livreur);
            $user = $session->get('user');
            $user->setLivreur($livreur);
            $man->persist($user);
            $man->flush();
            $this->addFlash('success','Compte cree avec Succes. Veillez vous connecter maintenant');
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('livreur/index.html.twig', [
            'form' => $livreur_form->createView(),
        ]);
    }
}
