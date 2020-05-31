<?php

namespace App\Controller;

use App\Entity\Diy;
use App\Form\DiyType;
use App\Repository\DiyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/diy")
 */
class DiyController extends AbstractController
{
    /**
     * @Route("/", name="diy_index", methods={"GET"})
     * @param DiyRepository $diyRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(DiyRepository $diyRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $diys = $diyRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $diys ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('diy/index.html.twig', [
            'diys' => $pagination
        ]);
    }

    /**
     * @Route("/creation/activite", name="diy_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $diy = new Diy();
        $user=$this->getUser();
        $form = $this->createForm(DiyType::class, $diy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $diy->setUser($user);
            $entityManager->persist($diy);
            $entityManager->flush();

            return $this->redirectToRoute('diy_index');
        }

        return $this->render('diy/new.html.twig', [
            'diy' => $diy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="diy_show", methods={"GET"})
     * @param Diy $diy
     * @return Response
     */
    public function show(Diy $diy): Response
    {
        return $this->render('diy/show.html.twig', [
            'diy' => $diy,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="diy_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == diy.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Diy $diy
     * @return Response
     */
    public function edit(Request $request, Diy $diy): Response
    {
        $form = $this->createForm(DiyType::class, $diy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diy_index');
        }

        return $this->render('diy/edit.html.twig', [
            'diy' => $diy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="diy_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == diy.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Diy $diy
     * @return Response
     */
    public function delete(Request $request, Diy $diy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($diy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('diy_index');
    }
}
