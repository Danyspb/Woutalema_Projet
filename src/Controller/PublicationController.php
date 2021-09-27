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
     * @param SessionInterface $session
     * @return Response
     */
    public function index(Request $req, EntityManagerInterface $manager,PublicationRepository $repos,ProduitRepository $pro, SessionInterface $session): Response
    {
        $nice = $session->get('test');
        $publication = new Publication();
        $form_pub = $this->createForm(PublicationType::class, $publication);
        $form_pub->handleRequest($req);
        if ($form_pub->isSubmitted() && $form_pub->isValid())
        {
            $publication->setProduit($nice);
            $publication->setDatePublication(new \DateTime());
            $manager->persist($publication);
            $manager->flush();
            
        }
        return $this->render('publication/index.html.twig',[
            'form' => $form_pub->createView()
        ]);

    }
}
