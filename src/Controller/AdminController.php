<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Entity\Types;
use App\Form\DomaineType;
use App\Form\TypeProduitType;
use App\Repository\DomaineRepository;
use App\Repository\TypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/types", name="types")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param TypesRepository $repos
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager, TypesRepository $repos): Response
    {
        $allType = $repos->findAll();
        $types = new Types();
        $type_form = $this->createForm(TypeProduitType::class, $types);
        $type_form->handleRequest($request);
        if ($type_form->isSubmitted() && $type_form->isValid())
        {
            $manager->persist($types);
            $manager->flush();
            return $this->redirectToRoute('types');
        }
        return $this->render('admin/typeprod_admin.html.twig', [
            'form'=> $type_form->createView(),
            'repo' => $allType,
        ]);
    }


    /**
     * @Route("/type_modify/{id}", name="type_modify")
     * @param Types $type
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param TypesRepository $repos
     * @return Response
     */
    public function modify(Types $type, Request $request, EntityManagerInterface $manager, TypesRepository $repos): Response
    {
        $allType = $repos->findAll();
        $modify_type = $this->createForm(TypeProduitType::class,$type);
        $modify_type->handleRequest($request);
        if ($modify_type->isSubmitted() && $modify_type->isValid())
        {

            $manager->persist($type);
            $manager->flush();
            return $this->redirectToRoute('types');
        }
        return $this->render('admin/moditypepro_admin.html.twig', [
            'form' => $modify_type->createView(),
            'repo' => $allType,
        ]);
    }

    /**
     * @Route("/types_supprimer/{id}", name="types_supp")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete($id,EntityManagerInterface $manager)
    {

        $types = $manager->getRepository(Types::class)->find($id);
        if ($types != null ){
            $manager->remove($types);
            $manager->flush();
        }
        return $this->redirectToRoute('types');
    }

    /**
     * @Route("/domaine", name="domaine")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DomaineRepository $rep
     * @return Response
     */
    public function domaine(Request $request, EntityManagerInterface $manager, DomaineRepository $rep): Response
    {
        $alldomains = $rep->findAll();
        $domaine = new Domaine();
        $domaine_form = $this->createForm(DomaineType::class,$domaine);
        $domaine_form->handleRequest($request);
        if ($domaine_form->isSubmitted() && $domaine_form->isValid())
        {
            $manager->persist($domaine);
            $manager->flush();
            return $this->redirectToRoute('domaine');
        }
        return $this->render('admin/domaine_admin.html.twig', [
            'form'=> $domaine_form->createView(),
            'repo' => $alldomains,
        ]);
    }

    /**
     * @Route("/domaine_modify/{id}", name="domaine_modify")
     * @param Domaine $domaine
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DomaineRepository $rep
     * @return Response
     */
    public function modifyDomaine( Domaine $domaine, Request $request, EntityManagerInterface $manager, DomaineRepository $rep): Response
    {
        $allDomaine = $rep->findAll();
        $modify_domaine = $this->createForm(DomaineType::class,$domaine);
        $modify_domaine->handleRequest($request);
        if ($modify_domaine->isSubmitted() && $modify_domaine->isValid())
        {

            $manager->persist($domaine);
            $manager->flush();
            return $this->redirectToRoute('domaine');
        }
        return $this->render('admin/modifydomain_admin.html.twig', [
            'form' => $modify_domaine->createView(),
            'repo' => $allDomaine,
        ]);
    }

    /**
     * @Route("/domaine_supprimer/{id}", name="domaine_supp")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleteDomaine($id,EntityManagerInterface $manager)
    {

        $domaine = $manager->getRepository(Domaine::class)->find($id);
        if ($domaine != null ){
            $manager->remove($domaine);
            $manager->flush();
        }
        return $this->redirectToRoute('domaine');
    }
}
