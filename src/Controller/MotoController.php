<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\s;

class MotoController extends AbstractController
{
    /**
     * @Route("/moto", name="moto")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $moto = new Moto();
        $moto_form = $this->createForm(MotoType::class,$moto);
        $moto_form->handleRequest($request);
        if ($moto_form->isSubmitted() && $moto_form->isValid())
        {
            $manager->persist($moto);
            $manager->flush();
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('moto/index.html.twig', [
            'form' => $moto_form->createView(),
        ]);
    }
}
