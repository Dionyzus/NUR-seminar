<?php
namespace App\Controller;

use App\Entity\Specijalizacija;
use App\Form\SpecijalizacijaFormType;
use App\Repository\SpecijalizacijaRepository;
use App\Repository\VlasnikRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SpecijalizacijaController extends AbstractController
{
    /**
     * Creates a new Specijalizacija entity.
     *
     * @Route("/app/specijalizacija/nova", methods={"GET", "POST"}, name="specijalizacija_nova")
     *
     */
    public function new(Request $request): Response
    {
        $specijalizacija = new Specijalizacija();
        $form = $this->createForm(SpecijalizacijaFormType::class, $specijalizacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($specijalizacija);
            $em->flush();

            $this->addFlash('success', 'Specijalizacija uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/specijalizacija.html.twig', [
            'specijalizacija' => $specijalizacija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Specijalizacija entity.
     * @Route("/app/specijalizacija/{specijalizacijaId<\d+>}", methods={"GET"}, name="specijalizacija_show")
     */
    public function show(Specijalizacija $specijalizacija): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showSpecijalizacija.html.twig', [
            'specijalizacija' => $specijalizacija,
        ]);
    }

    /**
     * Displays a form to edit an existing Specijalizacija entity.
     * @Route("/app/specijalizacija/{specijalizacijaId<\d+>}/edit",methods={"GET", "POST"}, name="specijalizacija_edit")
     */
    public function edit(Request $request, Specijalizacija $specijalizacija): Response
    {
        $form = $this->createForm(SpecijalizacijaFormType::class, $specijalizacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Specijalizacija uspješno ažurirana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editSpecijalizacija.html.twig', [
            'specijalizacija' => $specijalizacija,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Specijalizacija entity.
     * @Route("/app/specijalizacija/{specijalizacijaId}/delete", methods={"GET", "POST"}, name="specijalizacija_delete")
     */
    public function delete(Request $request, Specijalizacija $specijalizacija): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($specijalizacija);
        $em->flush();

        $this->addFlash('success', 'Specijalizacija uspješno izbrisana!');

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/app/specijalizacija/index",name="specijalizacija_index")
     */
    public function index(Request $request,SpecijalizacijaRepository $specijalizacijaRepository,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $specijalizacijaRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexSpecijalizacija.html.twig',['pagination'=>$pagination]);
    }
}