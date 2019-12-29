<?php
namespace App\Controller;

use App\Entity\Kategorija;
use App\Form\KategorijaFormType;
use App\Repository\HardwareRepository;
use App\Repository\KategorijaRepository;
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

class KategorijaController extends AbstractController
{
    /**
     * Creates a new Kategorija entity.
     *
     * @Route("/app/kategorija/nova", methods={"GET", "POST"}, name="kategorija_nova")
     *
     */
    public function new(Request $request): Response
    {
        $kategorija = new Kategorija();
        $form = $this->createForm(KategorijaFormType::class, $kategorija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($kategorija);
            $em->flush();

            $this->addFlash('success', 'Kategorija uspjesno dodana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/kategorija.html.twig', [
            'kategorija' => $kategorija,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Kategorija entity.
     * @Route("/app/kategorija/{kategorijaId<\d+>}", methods={"GET"}, name="kategorija_show")
     */
    public function show(Kategorija $kategorija): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('entitiesShow/showKategorija.html.twig', [
            'kategorija' => $kategorija,
        ]);
    }

    /**
     * Displays a form to edit an existing Kategorija entity.
     * @Route("/app/kategorija/{kategorijaId<\d+>}/edit",methods={"GET", "POST"}, name="kategorija_edit")
     */
    public function edit(Request $request, Kategorija $kategorija): Response
    {
        $form = $this->createForm(KategorijaFormType::class, $kategorija);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Kategorija uspješno ažurirana!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesActions/editKategorija.html.twig', [
            'kategorija' => $kategorija,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Kategorija entity.
     * @Route("/app/kategorija/{kategorijaId}/delete", methods={"GET", "POST"}, name="kategorija_delete")
     */
    public function delete(Request $request, Kategorija $kategorija): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($kategorija);
        $em->flush();

        $this->addFlash('success', 'Kategorija uspješno izbrisana!');

        return $this->redirectToRoute('app_index');
    }

    /**
     * @Route("/app/kategorija/index",name="kategorija_index")
     */
    public function index(Request $request,KategorijaRepository $kategorijaRepository,PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $kategorijaRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('entitiesShow/indexKategorija.html.twig',['pagination'=>$pagination]);
    }
}