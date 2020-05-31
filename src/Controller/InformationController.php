<?php

namespace App\Controller;

use App\Entity\Information;
use App\Form\InformationType;
use App\Form\SearchFormationType;
use App\Form\SearchInformationType;
use App\Repository\FormationRepository;
use App\Repository\InformationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/information")
 */
class InformationController extends AbstractController
{
    /**
     * @Route("/", name="information_index", methods={"GET"})
     * @param InformationRepository $informationRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(InformationRepository $informationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $informations = $informationRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $informations ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('information/index.html.twig', [
            'informations' => $pagination
        ]);
    }

    /**
     * @Route("/creation/information", name="information_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $information = new Information();
        $user=$this->getUser();
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $information->setUser($user);
            $entityManager->persist($information);
            $entityManager->flush();

            return $this->redirectToRoute('information_index');
        }

        return $this->render('information/new.html.twig', [
            'information' => $information,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="information_show", methods={"GET"})
     * @param Information $information
     * @return Response
     */
    public function show(Information $information): Response
    {
        return $this->render('information/show.html.twig', [
            'information' => $information,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="information_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == information.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Information $information
     * @return Response
     */
    public function edit(Request $request, Information $information): Response
    {
        $form = $this->createForm(InformationType::class, $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('information_index');
        }

        return $this->render('information/edit.html.twig', [
            'information' => $information,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="information_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == information.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Information $information
     * @return Response
     */
    public function delete(Request $request, Information $information): Response
    {
        if ($this->isCsrfTokenValid('delete'.$information->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($information);
            $entityManager->flush();
        }

        return $this->redirectToRoute('information_index');
    }
}
