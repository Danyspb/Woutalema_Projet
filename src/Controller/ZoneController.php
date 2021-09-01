<?php

namespace App\Controller;

use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZoneController extends AbstractController
{
    /**
     * @Route("/zone", name="zone")
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $req, EntityManagerInterface $manager): Response
    {

        $zone = new Zone();
        $zone_formulaire = $this->createForm(ZoneType::class,$zone);
        $zone_formulaire->handleRequest($req);
        if ($zone_formulaire->isSubmitted() && $zone_formulaire->isValid())
        {
            $livCon= $this->getUser()->getLivreur();
            $zone->setLivreur($livCon);
            $manager->persist($zone);
            $manager->flush();
            $this->addFlash('success', 'Zone ajoute avec Succes');

            return $this->redirectToRoute('all_zones');
        }
        return $this->render('zone/index.html.twig', [
            'form' => $zone_formulaire->createView(),
        ]);
    }

    /**
     * @Route("/all_zones", name="all_zones")
     * @param ZoneRepository $repos
     * @return Response
     */
    public function all_areas(ZoneRepository $repos): Response
    {
        $livreur = $this->getUser()->getLivreur();
        $zones = $repos->findAllAreaesId($livreur);

        return $this->render('zone/all_areas.html.twig',[
            'zones'=>$zones,
        ]);
    }

    /**
     * @Route("/info_zones/{id}", name="single_zone")
     * @param ZoneRepository $reposi
     * @param $id
     * @return Response
     */
    public function Zone(ZoneRepository $reposi, $id)
    {
        $info = $reposi->find($id);
        if ($info != null)
        {
            return $this->render('zone/info_zone.html.twig',[
                'zone' => $info,
            ]);
        }

    }

    /**
     * @Route("/supp_zone/{id}", name="supp_zone")
     *
     */
    public function delete($id,EntityManagerInterface $manager)
    {

        $zon = $manager->getRepository(Zone::class)->find($id);
        if ($zon != null ){
            $manager->remove($zon);
            $manager->flush();
            $this->addFlash('warning', 'Zone supprime avec Succes');
        }
        return $this->redirectToRoute('all_zones');
    }

    /**
     * @Route("/modify_zone/{id}", name="modify_zone")
     * @param Zone $mzone
     * @param EntityManagerInterface $manager
     * @param Request $reque
     * @return Response
     */
    public function modif(Zone $mzone ,EntityManagerInterface $manager, Request $reque): Response
    {
        $zone_modify = $this->createForm(ZoneType::class,$mzone);
        $zone_modify->handleRequest($reque);
        if ($zone_modify->isSubmitted() && $zone_modify->isValid())
        {
            $livCon= $this->getUser()->getLivreur();
            $mzone->setLivreur($livCon);
            $manager->persist($mzone);
            $manager->flush();
            $this->addFlash('notice', 'Zone modifie avec Succes');
            return  $this->redirectToRoute('all_zones');

        }
        return $this->render('zone/modify_zone.html.twig',[
           'form' => $zone_modify->createView()
        ]);

    }
}
