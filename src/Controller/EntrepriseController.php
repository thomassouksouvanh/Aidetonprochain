<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Form\SearchEntrepriseType;
use App\Form\SearchType;
use App\Repository\EntrepriseRepository;
use App\Repository\PropositionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="entreprise_index", methods={"GET"})
     * @param EntrepriseRepository $entrepriseRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(EntrepriseRepository $entrepriseRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $entreprises = $entrepriseRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $entreprises,
            $request->query->getInt('page',1),8
        );

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $pagination,
        ]);
    }


    /**
     * @Route("/creation/entreprise-partenaire", name="entreprise_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $entreprise = new Entreprise();
        $user=$this->getUser();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entreprise->setUser($user);
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="entreprise_show", methods={"GET"})
     * @param Entreprise $entreprise
     * @return Response
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="entreprise_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == entreprise.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Entreprise $entreprise
     * @return Response
     */
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="entreprise_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == entreprise.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Entreprise $entreprise
     * @return Response
     */
    public function delete(Request $request, Entreprise $entreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }

    public function filteredEntreprise(){

    }
}
