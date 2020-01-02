<?php

namespace App\Controller;

use App\Entity\Hardware;
use App\Entity\Software;
use App\Form\HardwareFormType;
use App\Form\SearchFormType;
use App\Repository\HardwareRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request)
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->search($form["brojUcionice"]->getData());
        }

        $userId = $this->getUser();

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);

        return $this->render("default/appIndex.html.twig", [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('default/homepage.html.twig');
    }

    /**
     * @Route("/app/hw_sw_index", name="hardware_software_search")
     */
    public function search($q)
    {
        $conn = $this->getDoctrine()->getConnection();

        $rawQuery1 = '
                SELECT lokacija.Broj_ucionice,hardware.Naziv_hardware,software.Naziv_Software
  FROM lokacija
   RIGHT JOIN hardware ON hardware.Broj_ucionice = lokacija.Broj_ucionice
   LEFT JOIN hardware_software ON hardware_software.Broj_inventara = hardware.Broj_inventara
   LEFT JOIN software ON software.Sifra_software = hardware_software.Sifra_software
WHERE lokacija.Broj_ucionice=:q
 ORDER BY hardware.Naziv_hardware
';

        $stmt = $conn->prepare($rawQuery1);
        $stmt->execute(['q' => $q]);
        $brojUcionice = $q->getBrojUcionice();
        $pagination = $stmt->fetchAll();

        if(sizeof($pagination) == 0)
        {
            return $this->render('entitiesActions/hardwareSoftwareIndexSearch.html.twig', ['brojUcionice' => $brojUcionice, 'pagination' => $pagination,'count' => 0]);
        }
        $count = 0;
        $equipment = array();
        $key = $pagination[0]['Naziv_hardware'];
        if($key)
        {
            $count+=1;
        }

        $equipment[$key] = array();
        $equipment[$key][0]=$pagination[0]['Naziv_Software'];
        if($equipment[$key][0])
        {
            $count+=1;
        }

        $element = 1;

        for ($x = 1; $x <= sizeof($pagination) - 1; $x++) {
            if($pagination[$x]['Naziv_hardware'] != $key)
            {
                $key = $pagination[$x]['Naziv_hardware'];
                $equipment[$key] = array();
                $equipment[$key][0]=$pagination[$x]['Naziv_Software'];
                $element = 1;
                $count+=2;
            }
            else {
                $equipment[$key][$element] = $pagination[$x]['Naziv_Software'];
                $element+=1;
                $count+=1;
            }
        }
        dump($equipment);

        return $this->render('entitiesActions/hardwareSoftwareIndexSearch.html.twig', ['brojUcionice' => $brojUcionice,'pagination' => $equipment,'count' => $count]);
    }

}
