<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau-commentaire/{slug}", name="comment_new")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param $slug
     * @param User $user
     * @return Response
     */
/*    public function new(Request $request,UserRepository $userRepository,$slug,User $user)
    {
        $comment = new Comment();
        $author  = $this->getUser();
        $profil  = $userRepository->findOneBy(['slug' => $slug]);

        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($request->isXMLHttpRequest()) {
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $comment->setAuthor($author);
                $comment->setProfil($profil);
                $entityManager->persist($comment);
                $entityManager->flush();
                return new JsonResponse(array('data' => 'this is a json response'));

            }
            return new Response('This is not ajax!', 400);
        }
        return $this->render('comment/new.html.twig', [
            'user'    => $user,
            'comment' => $comment,
            'form'    => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     * @param Comment $comment
     * @return Response
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
