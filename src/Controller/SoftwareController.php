<?php
namespace App\Controller;

use App\Entity\Software;
use App\Form\SoftwareFormType;
use App\Repository\LokacijaRepository;
use App\Repository\SoftwareRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SoftwareController extends AbstractController
{
    /**
     * Creates a new Software entity.
     *
     * @Route("/app/software/novi", methods={"GET", "POST"}, name="software_novi")
     *
     */
    public function new(Request $request): Response
    {
        $software = new Software();
        $form = $this->createForm(SoftwareFormType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($software);
            $em->flush();

            $this->addFlash('success', 'Softver uspjesno dodan!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/software.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Software entity.
     * @Route("/app/software/{sifraSoftware<\d+>}", methods={"GET"}, name="software_show")
     */
    public function show(Software $software): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showSoftware.html.twig', [
            'software' => $software,
        ]);
    }

    /**
     * Displays a form to edit an existing Software entity.
     * @Route("/app/software/{sifraSoftware<\d+>}/edit",methods={"GET", "POST"}, name="software_edit")
     */
    public function edit(Request $request, Software $software): Response
    {
        $form = $this->createForm(SoftwareFormType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Softver uspješno ažuriran!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editSoftware.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Software entity.
     * @Route("/app/software/{sifraSoftware}/delete", methods={"GET", "POST"}, name="software_delete")
     */
    public function delete(Request $request, Software $software): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($software);
        $em->flush();

        $this->addFlash('success', 'Software uspješno izbrisan');

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/app/software/index",name="software_index")
     */
    public function index(Request $request,SoftwareRepository $softwareRepository,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $softwareRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexSoftware.html.twig',['pagination'=>$pagination]);
    }
}