<?php
namespace App\Controller;

use App\Entity\Lokacija;
use App\Entity\Organizacija;
use App\Form\OrganizacijaFormType;
use App\Repository\OrganizacijaRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class OrganizacijaController extends AbstractController
{
    /**
     * Creates a new Organizacija entity.
     *
     * @Route("/app/organizacija/nova", methods={"GET", "POST"}, name="organizacija_nova")
     *
     */
    public function new(Request $request): Response
    {
        $organizacija = new Organizacija();
        $form = $this->createForm(OrganizacijaFormType::class, $organizacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($organizacija);
            $em->flush();

            $this->addFlash('success', 'Organizacija uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/organizacija.html.twig', [
            'organizacija' => $organizacija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Organizacija entity.
     * @Route("/app/organizacija/{organizacijaId<\d+>}", methods={"GET"}, name="organizacija_show")
     */
    public function show(Organizacija $organizacija): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showOrganizacija.html.twig', [
            'organizacija' => $organizacija,
        ]);
    }

    /**
     * Displays a form to edit an existing Organizacija entity.
     * @Route("/app/organizacija/{organizacijaId<\d+>}/edit",methods={"GET", "POST"}, name="organizacija_edit")
     */
    public function edit(Request $request, Organizacija $organizacija): Response
    {
        $form = $this->createForm(OrganizacijaFormType::class, $organizacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'All fields should be filled!');

            return $this->redirectToRoute('organizacija_index');
        }

        return $this->render('entitiesActions/editOrganizacija.html.twig', [
            'organizacija' => $organizacija,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Organizacija entity.
     * @Route("/app/organizacija/{organizacijaId}/delete", methods={"GET", "POST"}, name="organizacija_delete")
     */
    public function delete(Request $request, Organizacija $organizacija): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($organizacija);
        $em->flush();

        $this->addFlash('success', 'Organizacija deleted successfully');

        return $this->redirectToRoute('organizacija_index');
    }

    /**
     * @Route("/app/organizacija/index",name="organizacija_index")
     */
    public function index(Request $request,OrganizacijaRepository $organizacijaRepo)
    {
        $organizacije=$organizacijaRepo->findAll();
        return $this->render('entitiesShow/indexOrganizacija.html.twig',['organizacije' => $organizacije]);
    }
}