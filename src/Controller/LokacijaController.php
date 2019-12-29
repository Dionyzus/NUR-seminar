<?php
namespace App\Controller;

use App\Entity\Lokacija;
use App\Entity\Organizacija;
use App\Entity\Namjena;
use App\Entity\Ustanova;
use App\Form\LokacijaFormType;
use App\Repository\HardwareRepository;
use App\Repository\LokacijaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;

class LokacijaController extends AbstractController
{

    /**
     * Creates a new Lokacija entity.
     *
     * @Route("/app/lokacija/nova", methods={"GET", "POST"}, name="lokacija_nova")
     *
     */
    public function new(Request $request): Response
    {
        $lokacija = new Lokacija();
        $form = $this->createForm(LokacijaFormType::class, $lokacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($lokacija);
            $em->flush();

            $this->addFlash('success', 'Lokacija uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/lokacija.html.twig', [
            'lokacija' => $lokacija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Lokacija entity.
     * @Route("/app/lokacija/{brojUcionice<\d+>}", methods={"GET"}, name="lokacija_show")
     */
    public function show(Lokacija $lokacija): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showLokacija.html.twig', [
            'lokacija' => $lokacija,
        ]);
    }

    /**
     * Deletes a Lokacija entity.
     * @Route("/app/lokacija/{brojUcionice}/delete", methods={"GET", "POST"}, name="lokacija_delete")
     */
    public function delete(Lokacija $lokacija): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($lokacija);
        $em->flush();

        $this->addFlash('success', 'Lokacija uspješno izbrisana');

        return $this->redirectToRoute('app_index');
    }

    /**
     * Displays a form to edit an existing Lokacija entity.
     * @Route("/app/lokacija/{brojUcionice<\d+>}/edit",methods={"GET", "POST"}, name="lokacija_edit")
     */
    public function edit(Request $request, Lokacija $lokacija): Response
    {
        $form = $this->createForm(LokacijaFormType::class, $lokacija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Lokacija uspješno ažurirana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editLokacija.html.twig', [
            'lokacija' => $lokacija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/app/lokacija/index",name="lokacija_index")
     */
    public function index(Request $request,LokacijaRepository $lokacijaRepository,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $lokacijaRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexLokacija.html.twig',['pagination'=>$pagination]);
    }
}