<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceBabySittingType;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\PropositionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/annonce/faire-du-babysitting")
 */

class AnnonceBabySittingController extends AbstractController
{
    /**
     * @Route("/", name="annonce_babysitting_index")
     * @param AnnonceRepository $annonceRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $date = New \DateTime();
        $annonces = $annonceRepository->findAllByDateBabySitting($date);
        $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page',1), 8
        );

        return $this->render('annonce/babysitting/index.html.twig', [
            'annonces' => $pagination
        ]);
    }

    /**
     * @Route("/creation/babysitting", name="annonce_babysitting_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user= $this->getUser();
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceBabySittingType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setUser($user);
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_babysitting_index');
        }

        return $this->render('annonce/babysitting/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="annonce_babysitting_show", methods={"GET"})
     * @param Annonce $annonce
     * @return Response
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/babysitting/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="annonce_babysitting_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == annonce.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceBabySittingType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_babysitting_index');
        }

        return $this->render('annonce/babysitting/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="annonce_babysitting_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == annonce.getAuthor()", message="Vous n'avez pas le droit de supprimmer cette annoce")
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_babysitting_index');
    }


}

