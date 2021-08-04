<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
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
            $presCon= $this->getUser()->getPrestataire();
            $servi->setPrestataire($presCon);
            $manager->persist($servi);
            $manager->flush();
            return  $this->redirectToRoute('all_service');
        }
        return $this->render('service/index.html.twig', [
            'form' => $service_form->createView(),
        ]);
    }

    /**
     * @Route("all_service",name="all_service")
     * @param ServiceRepository $repos
     * @return Response
     */
    public function allService(ServiceRepository $repos): Response
    {
        $prestataire = $this->getUser()->getPrestataire();
        $serv = $repos->findAllServiceID($prestataire);

        return $this->render('service/all_services.html.twig',[
            'info' =>$serv,
        ]);
    }


    /**
     * @Route("single_service{id}",name="info_service")
     * @param ServiceRepository $repo
     * @param $id
     * @return Response
     *
     */
    public function Info( ServiceRepository $repo, $id)
    {
        $info = $repo->find($id);
        if ($info != null)
        {
            return $this->render('service/info_service.html.twig',[
                'service' => $info,
            ]);
        }
    }

    /**
     * @Route("modify_service{id}",name="serv_modi")
     * @param Service $service
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function modify(Service $service, Request $request, EntityManagerInterface $manager): Response
    {
        $modify_service = $this->createForm(ServiceType::class,$service);
        $modify_service->handleRequest($request);
        if ($modify_service->isSubmitted() && $modify_service->isValid())
        {

            $presCon= $this->getUser()->getPrestataire();
            $service->setPrestataire($presCon);
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute('all_service');
        }
        return $this->render('service/modify_service.html.twig', [
            'form' => $modify_service->createView(),
        ]);
    }

    /**
     * @Route("supprime_service/{id}",name="delete_service")
     * @param $id
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     */
    public function supprimer($id,EntityManagerInterface $manager)
    {

        $service = $manager->getRepository(Service::class)->find($id);
        if ($service != null ){
            $manager->remove($service);
            $manager->flush();
        }
        return $this->redirectToRoute('all_service');
    }
}
