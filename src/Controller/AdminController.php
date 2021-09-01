<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Entity\Etat;
use App\Entity\Types;
use App\Entity\User;
use App\Form\DomaineType;
use App\Form\EtatType;
use App\Form\TypeProduitType;
use App\Form\UserAdminType;
use App\Repository\DomaineRepository;
use App\Repository\EtatRepository;
use App\Repository\TypesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @Route("/allaCcount", name="all_account")
     */
    public function acceuiCompte(): Response
    {
        return $this->render('admin/acceui_admin.html.twig', [
            'controller_name' => 'AcceuilController',
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

    /**
     * @Route("/allaCcountPres", name="all_Prestataires")
     * @param UserRepository $repository
     * @return Response
     */
    public function AllPrestataire(UserRepository $repository):Response
    {
        $alluser = $repository->finAllPrestataire();
        return $this->render('admin/allCoun_admin.html.twig',[
            'repo' => $alluser,
        ]);
    }

    /**
     * @Route("/user_supprimer/{id}", name="user_supp")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleteCount($id,EntityManagerInterface $manager)
    {

        $user = $manager->getRepository(User::class)->find($id);
        if ($user != null ){
            $manager->remove($user);
            $manager->flush();
        }
        return $this->redirectToRoute('all_account');
    }


    /**
     * @Route("/user_ad", name="user_add")
     * @param Request $req
     * @param EntityManagerInterface $man
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function AdminAdd(Request $req ,EntityManagerInterface $man, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $user_form = $this->createForm(UserAdminType::class,$user);
        $user_form->handleRequest($req);
        if ($user_form->isSubmitted() && $user_form->isValid())
        {
            $user->setRoles((array)'ROLE_ADMIN');
            $has = $hasher->hashPassword($user,$user->getPassword());
            $user->setPassword($has);
            $man->persist($user);
            $man->flush();
            return $this->redirectToRoute('admin_account_all');
        }
        return $this->render('admin/addaccount_admin.html.twig', [
            'form' => $user_form->createView(),
        ]);
    }

    /**
     * @Route("/admin_account_all", name="admin_account_all")
     * @param UserRepository $repository
     * @return Response
     */
    public function AllAdminUser(UserRepository $repository):Response
    {
        $adminuser = $repository->finAllAdmin();
        return $this->render('admin/allCoun_admin.html.twig',[
            'repo' => $adminuser,
        ]);
    }

    /**
     * @Route("/allaCcountLivre", name="all_livreur")
     * @param UserRepository $repository
     * @return Response
     */
    public function AllLivreur(UserRepository $repository):Response
    {
        $alluser = $repository->finAllLivreur();
        return $this->render('admin/allCoun_admin.html.twig',[
            'repo' => $alluser,
        ]);
    }

    /**
     * @Route("/allaCcountClie", name="all_client")
     * @param UserRepository $repository
     * @return Response
     */
    public function AllClient(UserRepository $repository):Response
    {
        $alluser = $repository->finAllClient();
        return $this->render('admin/allCoun_admin.html.twig',[
            'repo' => $alluser,
        ]);
    }


    /**
     * @Route("/etats", name="etats")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param EtatRepository $repos
     * @return Response
     */
    public function Etat(Request $request, EntityManagerInterface $manager, EtatRepository $repos): Response
    {
        $Alletat = $repos->findAll();
        $situation = new Etat();
        $etat_form = $this->createForm(EtatType::class,$situation );
        $etat_form->handleRequest($request);
        if ($etat_form->isSubmitted() && $etat_form->isValid())
        {
            $manager->persist($situation);
            $manager->flush();
            return $this->redirectToRoute('etats');
        }
        return $this->render('admin/etat_admin.html.twig', [
            'form'=> $etat_form->createView(),
            'repo' => $Alletat,
        ]);
    }

    /**
     * @Route("/etat_supprimer/{id}", name="etat_supp")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleteEtat($id,EntityManagerInterface $manager)
    {

        $etat = $manager->getRepository(Etat::class)->find($id);
        if ($etat != null ){
            $manager->remove($etat);
            $manager->flush();
        }
        return $this->redirectToRoute('etats');
    }


}
