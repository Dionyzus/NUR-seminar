<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
