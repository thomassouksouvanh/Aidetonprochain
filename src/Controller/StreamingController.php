<?php

namespace App\Controller;

use App\Entity\Streaming;
use App\Form\StreamingType;
use App\Repository\StreamingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/streaming")
 */
class StreamingController extends AbstractController
{
    /**
     * @Route("/", name="streaming_index", methods={"GET"})
     * @param StreamingRepository $streamingRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(StreamingRepository $streamingRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $streamings = $streamingRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $streamings ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('streaming/index.html.twig', [
            'streamings' => $pagination
        ]);
    }



    /**
     * @Route("/creation/streaming", name="streaming_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $streaming = new Streaming();
        $user=$this->getUser();
        $form = $this->createForm(StreamingType::class, $streaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $streaming->setUser($user);
            $entityManager->persist($streaming);
            $entityManager->flush();

            return $this->redirectToRoute('streaming_index');
        }

        return $this->render('streaming/new.html.twig', [
            'streaming' => $streaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="streaming_show", methods={"GET"})
     * @param Streaming $streaming
     * @return Response
     */
    public function show(Streaming $streaming): Response
    {
        return $this->render('streaming/show.html.twig', [
            'streaming' => $streaming,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="streaming_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == streaming.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Streaming $streaming
     * @return Response
     */
    public function edit(Request $request, Streaming $streaming): Response
    {
        $form = $this->createForm(StreamingType::class, $streaming);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('streaming_index');
        }

        return $this->render('streaming/edit.html.twig', [
            'streaming' => $streaming,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="streaming_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == streaming.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Streaming $streaming
     * @return Response
     */
    public function delete(Request $request, Streaming $streaming): Response
    {
        if ($this->isCsrfTokenValid('delete'.$streaming->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($streaming);
            $entityManager->flush();
        }

        return $this->redirectToRoute('streaming_index');
    }
}
