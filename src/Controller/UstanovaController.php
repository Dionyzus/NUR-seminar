<?php
namespace App\Controller;

use App\Entity\Lokacija;
use App\Entity\Ustanova;
use App\Form\UstanovaFormType;
use App\Repository\UstanovaRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UstanovaController extends AbstractController
{
    /**
     * Creates a new Ustanova entity.
     *
     * @Route("/app/ustanova/nova", methods={"GET", "POST"}, name="ustanova_nova")
     *
     */
    public function new(Request $request): Response
    {
        $ustanova = new Ustanova();
        $form = $this->createForm(UstanovaFormType::class, $ustanova);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($ustanova);
            $em->flush();

            $this->addFlash('success', 'Ustanova uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/ustanova.html.twig', [
            'ustanova' => $ustanova,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Ustanova entity.
     * @Route("/app/ustanova/{ustanovaId<\d+>}", methods={"GET"}, name="ustanova_show")
     */
    public function show(Ustanova $ustanova): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showUstanova.html.twig', [
            'ustanova' => $ustanova,
        ]);
    }

    /**
     * Displays a form to edit an existing Ustanova entity.
     * @Route("/app/ustanova/{ustanovaId<\d+>}/edit",methods={"GET", "POST"}, name="ustanova_edit")
     */
    public function edit(Request $request, Ustanova $ustanova): Response
    {
        $form = $this->createForm(UstanovaFormType::class, $ustanova);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'All fields should be filled!');

            return $this->redirectToRoute('ustanova_index');
        }

        return $this->render('entitiesActions/editUstanova.html.twig', [
            'ustanova' => $ustanova,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Ustanova entity.
     * @Route("/app/ustanova/{ustanovaId}/delete", methods={"GET", "POST"}, name="ustanova_delete")
     */
    public function delete(Request $request, Ustanova $ustanova): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($ustanova);
        $em->flush();

        $this->addFlash('success', 'Ustanova deleted successfully');

        return $this->redirectToRoute('ustanova_index');
    }

    /**
     * @Route("/app/ustanova/index",name="ustanova_index")
     */
    public function index(Request $request,UstanovaRepository $ustanovaRepo)
    {
        $ustanove=$ustanovaRepo->findAll();
        return $this->render('entitiesShow/indexUstanova.html.twig',['ustanove' => $ustanove]);
    }
}