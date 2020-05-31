<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\User;
use App\Form\AnnonceShopType;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;
use App\Repository\PropositionRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/annonce/faire-les-courses")
 */
class AnnonceShopController extends AbstractController
{
    /**
     * @Route("/", name="annonce_courses_index", methods={"GET","POST"})
     * @param AnnonceRepository $annonceRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(AnnonceRepository $annonceRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $date = New \DateTime();
        $annonces =$annonceRepository->findAllByDateCourse($date);
        $pagination = $paginator->paginate(
            $annonces ,
            $request->query->getInt('page', 1), 8
        );
        return $this->render('annonce/courses/index.html.twig', [
            'annonces' => $pagination
        ]);
    }

    /**
     * @Route("/creation/course", name="annonce_courses_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $user = $this->getUser();
        $form = $this->createForm(AnnonceShopType::class, $annonce);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setUser($user);
            $entityManager->persist($annonce);

            $entityManager->flush();

            return $this->redirectToRoute('annonce_courses_index');
        }

        return $this->render('annonce/courses/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="annonce_courses_show", methods={"GET"})
     * @param Annonce $annonce
     * @return Response
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/courses/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="annonce_courses_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == annonce.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceShopType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_courses_index');
        }

        return $this->render('annonce/courses/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="annonce_courses_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == annonce.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
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

        return $this->redirectToRoute('annonce_courses_index');
    }


}
