<?php

namespace App\Controller;

use App\Entity\Gaming;
use App\Form\GamingType;
use App\Repository\GamingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/gaming")
 */
class GamingController extends AbstractController
{
    /**
     * @Route("/", name="gaming_index", methods={"GET"})
     * @param GamingRepository $gamingRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(GamingRepository $gamingRepository ,Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $gamings = $gamingRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $gamings ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('gaming/index.html.twig', [
            'gamings' => $pagination
        ]);
    }

    /**
     * @Route("/creation/gaming", name="gaming_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $gaming = new Gaming();
        $user=$this->getUser();
        $form = $this->createForm(GamingType::class, $gaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $gaming->setUser($user);
            $entityManager->persist($gaming);
            $entityManager->flush();

            return $this->redirectToRoute('gaming_index');
        }

        return $this->render('gaming/new.html.twig', [
            'gaming' => $gaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="gaming_show", methods={"GET"})
     * @param Gaming $gaming
     * @return Response
     */
    public function show(Gaming $gaming): Response
    {
        return $this->render('gaming/show.html.twig', [
            'gaming' => $gaming,
        ]);
    }

    /**
     * @Route("/{slug}/edition", name="gaming_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == gaming.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Gaming $gaming
     * @return Response
     */
    public function edit(Request $request, Gaming $gaming): Response
    {
        $form = $this->createForm(GamingType::class, $gaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gaming_index');
        }

        return $this->render('gaming/edit.html.twig', [
            'gaming' => $gaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="gaming_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == gaming.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Gaming $gaming
     * @return Response
     */
    public function delete(Request $request, Gaming $gaming): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gaming->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gaming);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gaming_index');
    }
}
