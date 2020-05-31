<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Form\PropositionShopType;
use App\Form\SearchType;
use App\Repository\PropositionRepository;
use App\Service\SearchPropositionController;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/proposition/faire-les-courses")
 */
class PropositionShopController extends AbstractController
{
    /**
     * @Route("/", name="proposition_courses_index")
     * @param PropositionRepository $propositionRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(PropositionRepository $propositionRepository, Request $request, PaginatorInterface $paginator)
    {
        $date = new \DateTime();
        $propositions = $propositionRepository->findAllByDateCourse($date);

        $pagination = $paginator->paginate(
            $propositions ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('proposition/courses/index.html.twig', [
            'propositions' => $pagination
        ]);
    }

    /**
     * @Route("/creation/courses", name="proposition_courses_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $proposition = new Proposition();
        $user=$this->getUser();
        $form = $this->createForm(PropositionShopType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $proposition->setUser($user);
            $entityManager->persist($proposition);
            $entityManager->flush();

            return $this->redirectToRoute('proposition_courses_index');
        }

        return $this->render('proposition/courses/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="proposition_courses_show", methods={"GET"})
     * @param Proposition $proposition
     * @return Response
     */
    public function show(Proposition $proposition): Response
    {
        return $this->render('proposition/courses/show.html.twig', [
            'proposition' => $proposition,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="proposition_courses_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == proposition.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Proposition $proposition
     * @return Response
     */
    public function edit(Request $request, Proposition $proposition): Response
    {
        $form = $this->createForm(PropositionShopType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proposition_courses_index');
        }

        return $this->render('proposition/courses/edit.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="proposition_courses_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == proposition.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Proposition $proposition
     * @return Response
     */
    public function delete(Request $request, Proposition $proposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('proposition_courses_index');
    }


}
