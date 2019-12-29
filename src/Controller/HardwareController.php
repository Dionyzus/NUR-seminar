<?php
namespace App\Controller;

use App\Entity\Hardware;
use App\Form\HardwareFormType;
use App\Repository\HardwareRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;

class HardwareController extends AbstractController
{
    /**
     * Creates a new Hardware entity.
     *
     * @Route("/app/hardware/novi", methods={"GET", "POST"}, name="hardware_novi")
     *
     */
    public function new(Request $request): Response
    {
        $hardware = new Hardware();
        $form = $this->createForm(HardwareFormType::class, $hardware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($hardware);
            $em->flush();

            $this->addFlash('success', 'Hardver uspjesno dodan!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/hardware.html.twig', [
            'hardware' => $hardware,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Hardware entity.
     * @Route("/app/hardware/{brojInventara<\d+>}", methods={"GET"}, name="hardware_show")
     */
    public function show(Hardware $hardware): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showHardware.html.twig', [
            'hardware' => $hardware,
        ]);
    }

    /**
     * Displays a form to edit an existing Hardware entity.
     * @Route("/app/hardware/{brojInventara<\d+>}/edit",methods={"GET", "POST"}, name="hardware_edit")
     */
    public function edit(Request $request, Hardware $hardware): Response
    {
        $form = $this->createForm(HardwareFormType::class, $hardware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Hardver je ažuriran!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editHardware.html.twig', [
            'hardware' => $hardware,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Hardware entity.
     * @Route("/app/hardware/{brojInventara}/delete", methods={"GET", "POST"}, name="hardware_delete")
     */
    public function delete(Request $request, Hardware $hardware): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($hardware);
        $em->flush();

        $this->addFlash('success', 'Hardware izbrisan uspješno!');

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/app/hardware/index",name="hardware_index")
     */
    public function index(Request $request,HardwareRepository $hardwareRepo,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $hardwareRepo->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexHardware.html.twig',['pagination'=>$pagination]);
    }


}