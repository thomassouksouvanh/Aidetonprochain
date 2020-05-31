<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\FlashmobType;
use App\Repository\VideoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/video/flashmob")
 */
class FlashMobController extends AbstractController
{
    /**
     * @Route("/", name="flashmob_index")
     * @param VideoRepository $videoRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(VideoRepository $videoRepository, Request $request, PaginatorInterface $paginator)
    {
        $date = new \DateTime();
        $videos = $videoRepository->findAllByDateFlashMob($date);

        $pagination = $paginator->paginate(
            $videos ,
            $request->query->getInt('page', 1), 6
        );

        return $this->render('flashmob/index.html.twig', [
            'videos' => $pagination
        ]);
    }

    /**
     * @Route("/creation/flashmob", name="flashmob_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $video = new Video();
        $user=$this->getUser();
        $form = $this->createForm(FlashmobType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $video->setUser($user);
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('flashmob_index');
        }

        return $this->render('flashmob/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="flashmob_show", methods={"GET"})
     * @param Video $video
     * @return Response
     */
    public function show(Video $video): Response
    {
        return $this->render('flashmob/show.html.twig', [
            'video' => $video,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="flashmob_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == video.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function edit(Request $request, Video $video): Response
    {
        $form = $this->createForm(FlashmobType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flashmob_index');
        }

        return $this->render('flashmob/edit.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="flashmob_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == video.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flashmob_index');
    }

}
