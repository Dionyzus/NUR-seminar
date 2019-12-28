<?php
namespace App\Controller;

use App\Entity\Vlasnik;
use App\Entity\User;
use App\Form\VlasnikFormType;
use App\Repository\VlasnikRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VlasnikController extends AbstractController
{
    /**
     * Creates a new Vlasnik entity.
     *
     * @Route("/app/vlasnik/novi", methods={"GET", "POST"}, name="vlasnik_novi")
     *
     */
    public function new(Request $request): Response
    {
        $vlasnik = new Vlasnik();
        $form = $this->createForm(VlasnikFormType::class, $vlasnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($vlasnik);
            $em->flush();

            $this->addFlash('success', 'Vlasnik uspjesno dodan!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/vlasnik.html.twig', [
            'vlasnik' => $vlasnik,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Vlasnik entity.
     * @Route("/app/vlasnik/{vlasnikId<\d+>}", methods={"GET"}, name="vlasnik_show")
     */
    public function show(Vlasnik $vlasnik): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showVlasnik.html.twig', [
            'vlasnik' => $vlasnik,
        ]);
    }

    /**
     * Displays a form to edit an existing Vlasnik entity.
     * @Route("/app/vlasnik/{vlasnikId<\d+>}/edit",methods={"GET", "POST"}, name="vlasnik_edit")
     */
    public function edit(Request $request, Vlasnik $vlasnik): Response
    {
        $form = $this->createForm(VlasnikFormType::class, $vlasnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'All fields should be filled!');

            return $this->redirectToRoute('vlasnik_index');
        }

        return $this->render('entitiesActions/editVlasnik.html.twig', [
            'vlasnik' => $vlasnik,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Vlasnik entity.
     * @Route("/app/vlasnik/{vlasnikId}/delete", methods={"GET", "POST"}, name="vlasnik_delete")
     */
    public function delete(Request $request, Vlasnik $vlasnik): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($vlasnik);
        $em->flush();

        $this->addFlash('success', 'Vlasnik deleted successfully');

        return $this->redirectToRoute('vlasnik_index');
    }

    /**
     * @Route("/app/vlasnik/index",name="vlasnik_index")
     */
    public function index(Request $request,VlasnikRepository $vlasnikRepo)
    {
        $vlasnici=$vlasnikRepo->findAll();
        return $this->render('entitiesShow/indexVlasnik.html.twig',['vlasnici' => $vlasnici]);
    }
}