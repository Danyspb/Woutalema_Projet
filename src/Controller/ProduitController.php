<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $produit = new Produit();
        $form_produit = $this->createForm(ProduitType::class,$produit);
        $form_produit->handleRequest($request);
        if ($form_produit->isSubmitted() && $form_produit->isValid())
        {
            $usCon= $this->getUser()->getClient();
            $produit->setClient($usCon);
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute('acceuil');
        }
        return $this->render('produit/index.html.twig', [
            'form' => $form_produit->createView(),
        ]);
    }

    /**
     *
     * @Route("/all_products",name="all_prod")
     * @param ProduitRepository $repos
     * @return Response
     */
    public function all(ProduitRepository $repos): Response
    {

        $info = $this->getUser()->getclient();

        return $this->render('produit/all_product.html.twig',[
            'produits'=>$info,
        ]);
    }
}
