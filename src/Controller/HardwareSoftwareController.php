<?php
namespace App\Controller;

use App\Entity\HardwareSoftware;
use App\Form\EditSoftwareHardwareFormType;
use App\Form\HardwareSoftwareFormType;
use App\Repository\HardwareRepository;
use App\Repository\HardwareSoftwareRepository;
use App\Repository\SoftwareRepository;
use App\Repository\SpecijalizacijaRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HardwareSoftwareController extends AbstractController
{
    /**
     * Creates a new HardwareSoftware entity.
     *
     * @Route("/app/hw_sw/novi", methods={"GET", "POST"}, name="hardware_software")
     *
     */
    public function new(Request $request): Response
    {
        $hw_sw = new HardwareSoftware();
        $form = $this->createForm(HardwareSoftwareFormType::class, $hw_sw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($hw_sw);
            $em->flush();

            $this->addFlash('success', 'Software uspjesno instaliran na hardware!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('entitiesAdd/hardwareSoftware.html.twig', [
            'hw_sw' => $hw_sw,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/app/hw_sw/index",name="hw_sw_index")
     */
    public function index(Request $request, HardwareSoftwareRepository $hardwareSoftwareRepo, SoftwareRepository $softwareRepo, HardwareRepository $hardwareRepo)
    {
        $hardwareSoftwares = $hardwareSoftwareRepo->findAll();
        $softwares = array();

        for ($i = 0; $i <= sizeof($hardwareSoftwares) - 1; $i++) {
            $id = $hardwareSoftwares[$i]->getSifraSoftware();
            $software = $softwareRepo->find($id);
            $softwares[] = $software;
        }

        $hardwareNames = array();
        for ($i = 0; $i <= sizeof($hardwareSoftwares) - 1; $i++) {
            $id = $hardwareSoftwares[$i]->getBrojInventara();
            $hardware = $hardwareRepo->find($id);
            $hardwareNames[] = $hardware;
        }
        return $this->render('entitiesShow/indexHardwareSoftware.html.twig', ['hardwareSoftwares' => $hardwareSoftwares, 'softwares' => $softwares,'hardwares'=>$hardwareNames]);
    }

    /**
     * @Route("/app/hw_sw/{brojInventara}/show", methods={"GET", "POST"}, name="hw_sw_show")
     */
    public function show(Request $request, HardwareSoftwareRepository $hwSwRepo,HardwareSoftware $hwSw,SoftwareRepository $softwareRepo, HardwareRepository $hardwareRepo): Response
    {
        $softwareHardware = $hwSwRepo->findSoftwareHardware($hwSw->getBrojInventara());
        $softwares = array();

        for ($i = 0; $i <= sizeof($softwareHardware) - 1; $i++) {
            $id = $softwareHardware[$i]->getSifraSoftware();
            $software = $softwareRepo->find($id);
            $softwares[] = $software;
        }

        $id = $softwareHardware[0]->getBrojInventara();
        $hardware = $hardwareRepo->find($id);


        return $this->render("entitiesShow/showHardwareSoftware.html.twig", [
            'hardware' => $hwSw,
            'softwares' => $softwares,
            'hardwareName'=>$hardware,
        ]);
    }

    /**
     * Displays a form to edit an existing HardwareSoftware entity.
     * @Route("/app/hw_sw/{brojInventara}/hw_swEdit",methods={"GET", "POST"}, name="hw_sw_edit")
     */
    public function edit(Request $request, HardwareSoftware $hardwareSoftware,HardwareRepository $hardwareRepo): Response
    {
        $form = $this->createForm(EditSoftwareHardwareFormType::class, $hardwareSoftware);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hw_sw_index');
        }

        $id = $hardwareSoftware->getBrojInventara();
        $hardware = $hardwareRepo->find($id);

        return $this->render('entitiesActions/editHardwareSoftware.html.twig', [
            'hardwareSoftware' => $hardwareSoftware,
            'hardware'=>$hardware,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a HardwareSoftware entity.
     * @Route("/app/hw_sw/{brojInventara}/delete", methods={"GET", "POST"}, name="hw_sw_delete")
     */
    public function delete(HardwareSoftware $hardwareSoftware): Response
    {
        //if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //return $this->redirectToRoute('homepage');
        //}

        $em = $this->getDoctrine()->getManager();
        $em->remove($hardwareSoftware);
        $em->flush();

        $this->addFlash('success', 'Hardver i svi softveri na istoj izbrisane uspješno!');

        return $this->redirectToRoute('hw_sw_index');
    }
}