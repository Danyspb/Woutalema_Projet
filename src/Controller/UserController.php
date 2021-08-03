<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     * @param SessionInterface $session
     * @param Request $req
     * @param EntityManagerInterface $man
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function index(SessionInterface $session, Request $req ,EntityManagerInterface $man, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $user_form = $this->createForm(UserType::class,$user);
        $user_form->handleRequest($req);
        if ($user_form->isSubmitted() && $user_form->isValid())
        {
            $role = $user->getRoles()[0];
            $has = $hasher->hashPassword($user,$user->getPassword());
            $user->setPassword($has);
            $man->persist($user);
            $session->set("user", $user);
            if ($role == "ROLE_CLIENT")
            {
                return $this->redirectToRoute('client');

            }
            if ($role == "ROLE_PRESTATAIRE")
            {
                return $this->redirectToRoute('prestataire');
            }
            if ($role == "ROLE_LIVREUR")
            {
                return $this->redirectToRoute('livreur');
            }

            return $this->redirectToRoute('acceuil');

        }
        return $this->render('user/index.html.twig', [
            'form' => $user_form->createView(),
        ]);
    }
}
