<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Form\SearchEntrepriseType;
use App\Form\SearchFormationType;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     * @param FormationRepository $formationRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(FormationRepository $formationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $formations = $formationRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $formations,
            $request->query->getInt('page',1),8
        );
        return $this->render('formation/index.html.twig', [
            'formations' => $pagination
        ]);
    }

    /**
     * @Route("/creation/formation", name="formation_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $user=$this->getUser();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $formation->setUser($user);
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="formation_show", methods={"GET"})
     * @param Formation $formation
     * @return Response
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="formation_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == formation.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Formation $formation
     * @return Response
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="formation_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == formation.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Formation $formation
     * @return Response
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_index');
    }
}
