<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\StoriesType;
use App\Repository\VideoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\VideoController;

/**
 * @Route("aide-ton-prochain/video/stories")
 */
class StoriesController extends AbstractController
{
    /**
     * @Route("/", name="stories_index")
     * @param VideoRepository $videoRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(VideoRepository $videoRepository, Request $request,PaginatorInterface $paginator)
    {

        $date = new \DateTime();
        $videos = $videoRepository->findAllByDateStorie($date);

        $pagination = $paginator->paginate(
            $videos ,
            $request->query->getInt('page', 1), 6
        );

        /*foreach ($stories as $key => $value){
                $test[$key] = $value->getSupport();
                if ( $test == "youtube") {
                $link[$key]['link'] = $value->getLink();
                $stories[$key] = $videoController->video_cleanURL_YT($link[$key]);
            }
        }*/

        return $this->render('stories/index.html.twig', [
            'videos' => $pagination
        ]);
    }

    /**
     * @Route("/creation/stories", name="stories_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $video = new Video();
        $user=$this->getUser();
        $form = $this->createForm(StoriesType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $video->setUser($user);
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('stories_index');
        }

        return $this->render('stories/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="stories_show", methods={"GET"})
     * @param Video $storie
     * @return Response
     */
    public function show(Video $storie): Response
    {
        return $this->render('stories/show.html.twig', [
            'video' => $storie,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="stories_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == video.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function edit(Request $request, Video $video): Response
    {
        $form = $this->createForm(StoriesType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stories_index');
        }

        return $this->render('stories/edit.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="stories_delete", methods={"DELETE"})
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

        return $this->redirectToRoute('stories_index');
    }
}
