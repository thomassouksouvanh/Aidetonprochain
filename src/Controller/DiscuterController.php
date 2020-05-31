<?php

namespace App\Controller;

use App\Entity\Discuter;
use App\Form\DiscuterType;
use App\Form\SearchDiscuterType;
use App\Form\SearchType;
use App\Repository\DiscuterRepository;
use App\Repository\PropositionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/discuter")
 */
class DiscuterController extends AbstractController
{
    /**
     * @Route("/", name="discuter_index", methods={"GET"})
     * @param DiscuterRepository $discuterRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(DiscuterRepository $discuterRepository,Request $request,PaginatorInterface $paginator): Response
    {

        $date = new \DateTime();
        $discuters = $discuterRepository->findAllByDate($date);
/*        $flag = true;
        $classcolor = [];
        foreach ($discuters as $key => $values) {;
            if ($flag) {
                $classcolor[$key] = "odd";
                $flag           = false;
            } else {
                $classcolor[$key] = "even";
                $flag           = true;
            }
        }*/
        $pagination = $paginator->paginate(
            $discuters ,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('discuter/index.html.twig', [
            'discuters' => $pagination,
/*            'classColor' => $classcolor*/
        ]);
    }

    /**
     * @Route("/creation/conversation", name="discuter_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $discuter = new Discuter();
        $user=$this->getUser();
        $form = $this->createForm(DiscuterType::class, $discuter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $discuter->setUser($user);
            $entityManager->persist($discuter);
            $entityManager->flush();

            return $this->redirectToRoute('discuter_index');
        }

        return $this->render('discuter/new.html.twig', [
            'discuter' => $discuter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="discuter_show", methods={"GET"})
     * @param Discuter $discuter
     * @return Response
     */
    public function show(Discuter $discuter): Response
    {
        return $this->render('discuter/show.html.twig', [
            'discuter' => $discuter,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="discuter_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == discuter.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Discuter $discuter
     * @return Response
     */
    public function edit(Request $request, Discuter $discuter): Response
    {
        $form = $this->createForm(DiscuterType::class, $discuter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('discuter_index');
        }

        return $this->render('discuter/edit.html.twig', [
            'discuter' => $discuter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="discuter_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == discuter.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Discuter $discuter
     * @return Response
     */
    public function delete(Request $request, Discuter $discuter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discuter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($discuter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('discuter_index');
    }
}
