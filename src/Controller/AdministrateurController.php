<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{

    /**
     * @param UserRepository $userRepository
     * @Route("admin/user",name="all_add_user")
     * @return Response
     */
    public function index(UserRepository $userRepository)
    {
        $repos = $userRepository->findAll();
        return $this->render("administrateur/index.html.twig",[
            'form'=>$repos,
        ]);
    }
}
