<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PrestataireController extends AbstractController
{
    /**
     * @Route("/prestataire", name="prestataire")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $prestataire = new Prestataire();
        $form_prestataire = $this->createForm(PrestataireType::class,$prestataire);
        $form_prestataire->handleRequest($request);
        if ($form_prestataire->isSubmitted() && $form_prestataire->isValid())
        {
            $user = $session->get('user');
            $user->setPrestataire($prestataire);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('prestataire/index.html.twig', [
            'form' => $form_prestataire->createView(),
        ]);
    }
}
