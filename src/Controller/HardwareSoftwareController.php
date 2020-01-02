<?php

namespace App\Controller;

use App\Entity\Hardware;
use App\Entity\HardwareSoftware;
use App\Entity\Software;
use App\Entity\Specijalizacija;
use App\Form\AssignSoftwareToHardware;
use App\Form\EditSoftwareHardwareFormType;
use App\Form\HardwareSoftwareFormType;
use App\Repository\HardwareRepository;
use App\Repository\HardwareSoftwareRepository;
use App\Repository\SoftwareRepository;
use App\Repository\SpecijalizacijaRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HardwareSoftwareController extends AbstractController
{
    /**
     * Creates a new HardwareSoftware entity.
     *
     * @Route("/app/hw_sw/novi", methods={"GET", "POST"}, name="hardware_software_novi")
     *
     */
    public function new(Request $request): Response
    {
        $hw_sw = new HardwareSoftware();
        $form = $this->createForm(HardwareSoftwareFormType::class, $hw_sw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($hw_sw);
            $em->flush();

            $this->addFlash('success', 'Software uspjesno instaliran na hardware!');

            return $this->redirectToRoute('app_index');
       }

        return $this->render('entitiesAdd/hardwareSoftware.html.twig', [
            'hw_sw' => $hw_sw,
           'form' => $form->createView(),
       ]);
    }

    /**
     * @Route("/app/hw_sw/index",name="hw_sw_index")
     */
    public function index(HardwareSoftwareRepository $hardwareSoftwareRepo, SoftwareRepository $softwareRepo, HardwareRepository $hardwareRepo)
    {
        $hardwareSoftwares = $hardwareSoftwareRepo->findAll();
        $softwares = array();

        for ($i = 0; $i <= sizeof($hardwareSoftwares) - 1; $i++) {
            $id = $hardwareSoftwares[$i]->getSifraSoftware();
            $software = $softwareRepo->find($id);
            $softwares[] = $software;
        }

        $hardwareNames = array();
        for ($i = 0; $i <= sizeof($hardwareSoftwares) - 1; $i++) {
            $id = $hardwareSoftwares[$i]->getBrojInventara();
            $hardware = $hardwareRepo->find($id);
            $hardwareNames[] = $hardware;
        }

        return $this->render('entitiesShow/indexHardwareSoftware.html.twig', ['hardwareSoftwares' => $hardwareSoftwares, 'softwares' => $softwares, 'hardwares' => $hardwareNames]);
    }

    /**
     * @Route("/app/hw_sw/{brojInventara}/show", methods={"GET", "POST"}, name="hw_sw_show")
     */
    public function show(HardwareSoftwareRepository $hwSwRepo, HardwareRepository $hwRepo,$brojInventara): Response
    {
        $doctrine = $this->getDoctrine();
        $softwares = $doctrine
            ->getRepository(Software::class)
            ->findAll();

        $hardware = $hwRepo->find($brojInventara);
        $assignedSoftware = $hwSwRepo->findSoftwareAssignedToHardware($brojInventara);

        $assignedSoftware = array_map(function ($row) {
            return $row->getSifraSoftware();
        }, $assignedSoftware);

        $result = array_diff($softwares, $assignedSoftware);

        $softwareNazivi = array();
        for ($x = 0; $x <= sizeof($assignedSoftware) - 1; $x++) {
            $software = $doctrine->getRepository(Software::class)->find($assignedSoftware[$x]);
            $softwareNazivi[] = $software->getNazivSoftware();
        }

        return $this->render("entitiesShow/showHardwareSoftware.html.twig", [
            'hardware' => $hardware,
            'softwares' => $softwares,
            "assignedSoftware" => $assignedSoftware,
            "unassignedSoftware" => $result,
            "nazivi" => $softwareNazivi
        ]);
    }

    /**
     * Displays a form to edit an existing HardwareSoftware entity.
     * @Route("/app/hw_sw/{brojInventara}/hw_swEdit/{sifraSoftware}",methods={"GET", "POST"}, name="hw_sw_edit")
     */
    public function edit(Request $request, $brojInventara, $sifraSoftware): Response
    {
        $doctrine = $this->getDoctrine();
        $hardware = $doctrine->getRepository(Hardware::class)->find($brojInventara);
        $software = $doctrine->getRepository(Software::class)->find($sifraSoftware);

        $hw_sw = new HardwareSoftware();
        $hw_sw
            ->setBrojInventara($brojInventara)
            ->setSifraSoftware($sifraSoftware);

        $form = $this->createForm(AssignSoftwareToHardware::class, $hw_sw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($hw_sw);
            $em->flush();

            $this->addFlash('success', 'Softver instaliran na hardveru uspješno!');

            return $this->redirectToRoute('hw_sw_show', [
                'brojInventara' => $brojInventara,
            ]);
        }

        return $this->render('entitiesActions/editHardwareSoftware.html.twig', [
            'hardwareSoftware' => $hw_sw,
            'form' => $form->createView(),
            'hardware'=>$hardware,
            'software'=>$software
        ]);
    }

    /**
     * @Route("/app/hw_sw/{brojInventara}/assign/{sifraSoftware}", name="hardware_software")
     * @IsGranted("ROLE_ADMIN")
     */
    public function assign($brojInventara, $sifraSoftware)
    {
        $doctrine = $this->getDoctrine();

        $hardware = $doctrine->getRepository(Hardware::class)->find($brojInventara);
        $hardware->getBrojInventara();
        $software = $doctrine->getRepository(Software::class)->find($sifraSoftware);
        $software->getSifraSoftware();


        return $this->redirectToRoute('hw_sw_edit', [
            'brojInventara' => $hardware,
            'sifraSoftware' => $software
        ]);
    }

    /**
     * @Route("/app/hw_sw/{brojInventara}/unassign/{sifraSoftware}", name="hw_sw_unassign")
     * @IsGranted("ROLE_ADMIN")
     */
    public function unassign($brojInventara, $sifraSoftware)
    {
        $doctrine = $this->getDoctrine();
        $hardware = $doctrine->getRepository(Hardware::class)->find($brojInventara);

        $hardwareSoftware = $doctrine->getRepository(HardwareSoftware::class)->findOneBy(['brojInventara' => $brojInventara, 'sifraSoftware' => $sifraSoftware]);

        $em = $doctrine->getManager();
        $em->remove($hardwareSoftware);
        $em->persist($hardware);
        $em->flush();

        $this->addFlash('success', 'Softver uspjesno izbrisan s hardvera!');

        return $this->redirectToRoute('hw_sw_show', [
            'brojInventara' => $brojInventara,
        ]);
    }
}