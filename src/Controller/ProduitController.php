<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
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
            return $this->redirectToRoute('all_prod');
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
        $client = $this->getUser()->getclient();
        $produits = $repos->findAllProducId($client);

        return $this->render('produit/all_product.html.twig',[
            'produits'=>$produits,
        ]);
    }

    /**
     * @Route("info_produit/{id}", name="single_prod")
     * @param ProduitRepository $reposi
     * @return Response
     */

    public function singleProd(ProduitRepository $reposi, $id)
    {
        $info = $reposi->find($id);
        if ($info != null)
        {
            return $this->render('produit/info_product.html.twig',[
                'produit' => $info,
            ]);
        }else
        {
            echo 'Erreur 404';
        }

    }


    /**
     * @Route("/produit_supprimer{id}", name="produit_supp")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id,EntityManagerInterface $manager)
    {

        $prod = $manager->getRepository(Produit::class)->find($id);
        if ($prod != null ){
            $manager->remove($prod);
            $manager->flush();
        }
        return $this->redirectToRoute('all_prod');
    }


    /**
     * @Route("/produit_modify/{id}", name="produit_modify")
     * @param Produit $prod
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     * @return Response
     */
    public function modify(Produit $prod, Request $request, EntityManagerInterface $manager,SessionInterface $session): Response
    {

        $modify_prooduit = $this->createForm(ProduitType::class,$prod);
        $modify_prooduit->handleRequest($request);
        if ($modify_prooduit->isSubmitted() && $modify_prooduit->isValid())
        {

            $usCon= $this->getUser()->getClient();
            $prod->setClient($usCon);
            $manager->persist($prod);
            $manager->flush();
            return $this->redirectToRoute('all_prod');
        }
        return $this->render('produit/modify_produit.html.twig', [
            'form' => $modify_prooduit->createView(),
        ]);
    }
}
