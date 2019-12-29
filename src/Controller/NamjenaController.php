<?php
namespace App\Controller;

use App\Entity\Namjena;
use App\Entity\Lokacija;
use App\Form\NamjenaFormType;
use App\Repository\KategorijaRepository;
use App\Repository\NamjenaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NamjenaController extends AbstractController
{
    /**
     * Creates a new Namjena entity.
     *
     * @Route("/app/namjena/nova", methods={"GET", "POST"}, name="namjena_nova")
     *
     */
    public function new(Request $request): Response
    {
        $namjena = new Namjena();
        $form = $this->createForm(NamjenaFormType::class, $namjena);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($namjena);
            $em->flush();

            $this->addFlash('success', 'Namjena uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/namjena.html.twig', [
            'namjena' => $namjena,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Namjena entity.
     * @Route("/app/namjena/{namjenaId<\d+>}", methods={"GET"}, name="namjena_show")
     */
    public function show(Namjena $namjena): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showNamjena.html.twig', [
            'namjena' => $namjena,
        ]);
    }

    /**
     * Displays a form to edit an existing Namjena entity.
     * @Route("/app/namjena/{namjenaId<\d+>}/edit",methods={"GET", "POST"}, name="namjena_edit")
     */
    public function edit(Request $request, Namjena $namjena): Response
    {
        $form = $this->createForm(NamjenaFormType::class, $namjena);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Namjena uspješno ažurirana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editNamjena.html.twig', [
            'namjena' => $namjena,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Namjena entity.
     * @Route("/app/namjena/{namjenaId}/delete", methods={"GET", "POST"}, name="namjena_delete")
     */
    public function delete(Request $request, Namjena $namjena): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($namjena);
        $em->flush();

        $this->addFlash('success', 'Namjena uspješno izbrisana!');

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/app/namjena/index",name="namjena_index")
     */
    public function index(Request $request,NamjenaRepository $namjenaRepository,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $namjenaRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexNamjena.html.twig',['pagination'=>$pagination]);
    }
}