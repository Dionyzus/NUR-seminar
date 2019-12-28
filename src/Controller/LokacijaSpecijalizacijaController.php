<?php

namespace App\Controller;

use App\Entity\LokacijaSpecijalizacija;
use App\Form\EditSpecijalizacijeLokacijeFormType;
use App\Form\LokacijaSpecijalizacijaFormType;
use App\Repository\LokacijaSpecijalizacijaRepository;
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
     * @Route("/app/lok_spec/nova", methods={"GET", "POST"}, name="lokacija_specijalizacija")
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

            $this->addFlash('success', 'Specijalizacija uspješno dodana lokaciji!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/lokacijaSpecijalizacija.html.twig', [
            'loc_spec' => $lok_spec,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/app/lok_spec/index",name="lok_spec_index")
     */
    public function index(Request $request, LokacijaSpecijalizacijaRepository $lokacijaSpecijalizacijaRepo, SpecijalizacijaRepository $specijalizacijaRepo)
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
    public function show(Request $request, LokacijaSpecijalizacijaRepository $lokSpecRepo,LokacijaSpecijalizacija $lokSpec,SpecijalizacijaRepository $specijalizacijaRepo): Response
    {
        $specijalizacijeLokacije = $lokSpecRepo->findSpecijalizacijeLokacije($lokSpec->getUcionicaBroj());
        $specijalizacije = array();

        for ($i = 0; $i <= sizeof($specijalizacijeLokacije) - 1; $i++) {
            $id = $specijalizacijeLokacije[$i]->getSpecijalizacijaId();
            $specijalizacija = $specijalizacijaRepo->find($id);
            $specijalizacije[] = $specijalizacija;
        }

        return $this->render("entitiesShow/showLokacijaSpecijalizacija.html.twig", [
            'lokacija' => $lokSpec,
            "specijalizacije" => $specijalizacije,
        ]);
    }

    /**
     * Displays a form to edit an existing LokacijaSpecijalizacija entity.
     * @Route("/app/lok_spec/{ucionicaBroj}/lok_specEdit",methods={"GET", "POST"}, name="lok_spec_edit")
     */
    public function edit(Request $request, LokacijaSpecijalizacija $lokacijaSpecijalizacija): Response
    {
        $form = $this->createForm(EditSpecijalizacijeLokacijeFormType::class, $lokacijaSpecijalizacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lok_spec_index');
        }

        return $this->render('entitiesActions/editLokacijaSpecijalizacija.html.twig', [
            'lokacijaSpecijalizacija' => $lokacijaSpecijalizacija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a LokacijaSpecijalizacija entity.
     * @Route("/app/lok_spec/{ucionicaBroj}/delete", methods={"GET", "POST"}, name="lok_spec_delete")
     */
    public function delete(LokacijaSpecijalizacija $lokacijaSpecijalizacija): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($lokacijaSpecijalizacija);
        $em->flush();

        $this->addFlash('success', 'Lokacija i sve specijalizacije na istoj izbrisane uspješno!');

        return $this->redirectToRoute('lok_sec_index');
    }
}