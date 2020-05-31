<?php

namespace App\Controller;

use App\Entity\Initiative;
use App\Form\InitiativeType;
use App\Form\SearchInitiativeType;
use App\Repository\InitiativeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/initiative")
 */
class InitiativeController extends AbstractController
{
    /**
     * @Route("/", name="initiative_index", methods={"GET"})
     * @param InitiativeRepository $initiativeRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(InitiativeRepository $initiativeRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $initiatives = $initiativeRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $initiatives ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('initiative/index.html.twig', [
            'initiatives' => $pagination
        ]);
    }

    /**
     * @Route("/creation/initiative", name="initiative_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $initiative = new Initiative();
        $user=$this->getUser();
        $form = $this->createForm(InitiativeType::class, $initiative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $initiative->setUser($user);
            $entityManager->persist($initiative);
            $entityManager->flush();

            return $this->redirectToRoute('initiative_index');
        }

        return $this->render('initiative/new.html.twig', [
            'initiative' => $initiative,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="initiative_show", methods={"GET"})
     * @param Initiative $initiative
     * @return Response
     */
    public function show(Initiative $initiative): Response
    {
        return $this->render('initiative/show.html.twig', [
            'initiative' => $initiative,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="initiative_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == initiative.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Initiative $initiative
     * @return Response
     */
    public function edit(Request $request, Initiative $initiative): Response
    {
        $form = $this->createForm(InitiativeType::class, $initiative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('initiative_index');
        }

        return $this->render('initiative/edit.html.twig', [
            'initiative' => $initiative,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="initiative_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == initiative.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Initiative $initiative
     * @return Response
     */
    public function delete(Request $request, Initiative $initiative): Response
    {
        if ($this->isCsrfTokenValid('delete'.$initiative->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($initiative);
            $entityManager->flush();
        }

        return $this->redirectToRoute('initiative_index');
    }
}
