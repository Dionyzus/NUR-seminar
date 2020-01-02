<?php

namespace App\Controller;

use App\Entity\Hardware;
use App\Entity\HardwareSoftware;
use App\Entity\Lokacija;
use App\Entity\LokacijaSpecijalizacija;
use App\Entity\Software;
use App\Entity\Specijalizacija;
use App\Form\AssignSoftwareToHardware;
use App\Form\HardwareSoftwareFormType;
use App\Form\LokacijaSpecijalizacijaFormType;
use App\Repository\HardwareRepository;
use App\Repository\HardwareSoftwareRepository;
use App\Repository\LokacijaRepository;
use App\Repository\LokacijaSpecijalizacijaRepository;
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

class LokacijaSpecijalizacijaController extends AbstractController
{
    /**
     * Creates a new LokacijaSpecijalizacija entity.
     *
     * @Route("/app/lok_spec/nova", methods={"GET", "POST"}, name="lokacija_specijalizacija_nova")
     *
     */
    public function new(Request $request): Response
    {
        $lok_spec = new LokacijaSpecijalizacija();
        $form = $this->createForm(LokacijaSpecijalizacijaFormType::class, $lok_spec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($lok_spec);
            $em->flush();

            $this->addFlash('success', 'Specijalizacija uspjesno dodana na hardware!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/lokacijSpecijalizacija.html.twig', [
            'lok_spec' => $lok_spec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/app/lok_spec/index",name="lok_spec_index")
     */
    public function index(LokacijaSpecijalizacijaRepository $lokacijaSpecijalizacijaRepo, SpecijalizacijaRepository $specijalizacijaRepo, LokacijaRepository $lokacijaRepo)
    {
        $lokacijaSpecijalizacije = $lokacijaSpecijalizacijaRepo->findAll();
        $specijalizacije = array();

        for ($i = 0; $i <= sizeof($lokacijaSpecijalizacije) - 1; $i++) {
            $id = $lokacijaSpecijalizacije[$i]->getSpecijalizacijaId();
            $specijalizacija = $specijalizacijaRepo->find($id);
            $specijalizacije[] = $specijalizacija;
        }

        return $this->render('entitiesShow/indexLokacijaSpecijalizacija.html.twig', ['lokacijaSpecijalizacije' => $lokacijaSpecijalizacije, 'specijalizacije' => $specijalizacije]);
    }

    /**
     * @Route("/app/lok_spec/{ucionicaBroj}/show", methods={"GET", "POST"}, name="lok_spec_show")
     */
    public function show(LokacijaSpecijalizacijaRepository $lokSpecRepo, LokacijaRepository $lokacijaRepo,$ucionicaBroj): Response
    {
        $doctrine = $this->getDoctrine();
        $specijalizacije = $doctrine
            ->getRepository(Specijalizacija::class)
            ->findAll();

        $lokacija = $lokacijaRepo->find($ucionicaBroj);
        $assignedSpecijalizacije = $lokSpecRepo->findSpecijalizacijaAssignedToLokacija($ucionicaBroj);

        $assignedSpecijalizacije = array_map(function ($row) {
            return $row->getSpecijalizacijaId();
        }, $assignedSpecijalizacije);

        $result = array_diff($specijalizacije, $assignedSpecijalizacije);

        $specijalizacijeNazivi = array();
        for ($x = 0; $x <= sizeof($assignedSpecijalizacije) - 1; $x++) {
            $specijalizacija = $doctrine->getRepository(Specijalizacija::class)->find($assignedSpecijalizacije[$x]);
            $specijalizacijeNazivi[] = $specijalizacija->getNazivSpecijalizacije();
        }

        return $this->render("entitiesShow/showLokacijaSpecijalizacija.html.twig", [
            'lokacija' => $lokacija,
            'specijalizacije' => $specijalizacije,
            "assignedSpecijalizacije" => $assignedSpecijalizacije,
            "unassignedSpecijalizacije" => $result,
            "nazivi" => $specijalizacijeNazivi
        ]);
    }

    /**
     * @Route("/app/lok_spec/{ucionicaBroj}/assign/{specijalizacijaId}", name="lokacija_specijalizacija")
     * @IsGranted("ROLE_ADMIN")
     */
    public function assign($ucionicaBroj, $specijalizacijaId): Response
    {
        $doctrine = $this->getDoctrine();

        $lok_spec = new LokacijaSpecijalizacija();
        $lok_spec
            ->setUcionicaBroj($ucionicaBroj)
            ->setSpecijalizacijaId($specijalizacijaId);

        $em = $doctrine->getManager();
        $em->persist($lok_spec);
        $em->flush();

        $this->addFlash('success', 'Specijalizacija uspješno pridružena lokaciji!');

        return $this->redirectToRoute('lok_spec_show', [
            'ucionicaBroj' => $ucionicaBroj,
        ]);
    }

    /**
     * @Route("/app/lok_spec/{ucionicaBroj}/unassign/{specijalizacijaId}", name="lok_spec_unassign")
     * @IsGranted("ROLE_ADMIN")
     */
    public function unassign($ucionicaBroj, $specijalizacijaId)
    {
        $doctrine = $this->getDoctrine();
        $lokacija = $doctrine->getRepository(Lokacija::class)->find($ucionicaBroj);

        $lokacijaSpecijalizacija = $doctrine->getRepository(LokacijaSpecijalizacija::class)->findOneBy(['ucionicaBroj' => $ucionicaBroj, 'specijalizacijaId' => $specijalizacijaId]);

        $em = $doctrine->getManager();
        $em->remove($lokacijaSpecijalizacija);
        $em->persist($lokacija);
        $em->flush();

        $this->addFlash('success', 'Specijalizacija uspješno uklonjena s lokacije!');

        return $this->redirectToRoute('lok_spec_show', [
            'ucionicaBroj' => $ucionicaBroj,
        ]);
    }
}