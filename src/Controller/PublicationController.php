<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\ProduitRepository;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publication/{id}", name="publication")
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @param PublicationRepository $repos
     * @param ProduitRepository $pro
     * @return Response
     */
    public function index(Request $req, EntityManagerInterface $manager,PublicationRepository $repos,ProduitRepository $pro): Response
    {

        $pro->findAll();
        $ALLpub = $repos->findAll();
        $publication = new Publication();
        $publi_form = $this->createForm(PublicationType::class, $publication);
        $publi_form->handleRequest($req);
        if ($publi_form->isSubmitted() && $publi_form->isValid())

        {
            $publication->setDatePublication(new \DateTime());
            $manager->persist($publication);
            $manager->flush();
            dd($publication);
        }
        return $this->render('publication/index.html.twig', [
            'form'=> $publi_form->createView(),
        ]);
    }
}
