<?php

namespace App\Controller;

use App\Entity\Hardware;
use App\Repository\HardwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller;

class MainController extends AbstractController
{
    /**
     * @Route("/app/index", name="app_index")
     */
    public function index()
    {
        $userId=$this->getUser();

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);

        return $this->render("default/appIndex.html.twig", [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('default/homepage.html.twig');
    }


    public function searchByLokacija(Request $request)
    {
        $qb = $this->getDoctrine()
            ->getRepository(HardwareRepository::class)
            ->findBy([Hardware::class]);

        $hardware = $this->get('pagination_factory')
            ->createCollection($qb, $request, 'hardware_collection');

        return $this->render('entitiesShow/indexHardware.html.twig',['hardware' => $hardware]);
    }

}
