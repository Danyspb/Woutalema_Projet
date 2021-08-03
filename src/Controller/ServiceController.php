<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $servi = new Service();
        $service_form = $this->createForm(ServiceType::class,$servi);
        $service_form->handleRequest($request);
        if ($service_form->isSubmitted() && $service_form->isValid())
        {
            $manager->persist($servi);
            $manager->flush();
            return  $this->redirectToRoute('all_service');
        }
        return $this->render('service/index.html.twig', [
            'form' => $service_form->createView(),
        ]);
    }

    /**
     * @Route("all_servvice",name="all_service")
     * @return Response
     *
     */
    public function allService(): Response
    {
        return null;
    }
}
