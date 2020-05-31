<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\ChangeAvatarType;
use App\Form\CommentType;
use App\Form\UserType;

use App\Repository\CommentRepository;
use App\Repository\UserRepository;

use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user/index", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * Permet d'afficher le profil de l'user connecté
     * @Route("/account/{slug}", name="account_user")
     * @param User $user
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param UserRepository $userRepository
     * @param $slug
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function Account(User $user,CommentRepository $commentRepository,Request $request,UserRepository $userRepository,$slug)
    {
        $comment = new Comment();
        $author  = $this->getUser();
        $profil  = $userRepository->findOneBy(['slug' => $slug]);

        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setAuthor($author);
                $comment->setProfil($profil);
                $entityManager->persist($comment);
                $entityManager->flush();

            }

        return $this->render('user/account.html.twig',[
            'user' => $user,
            'comments' => $commentRepository->findBy(['profil'=>$user]),
            'comment' => $comment,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/changement/avatar/{slug}", name="change_avatar")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function changeAvatar(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeAvatarType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success','Votre avatar a bien été modifié');

            return $this->redirectToRoute('account_user');

        }

        return $this->render('user/avatar.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/creation-nouvelle-utilisateur", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editer/compte/{slug}", name="user_account_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success','Votre profil a été mis à jour');
            $slug = $this->getUser()->getSlug();
            return $this->redirectToRoute('account_user',['slug' =>$slug]);
        }

        return $this->render('user/account_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{slug}", name="user_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }


}
