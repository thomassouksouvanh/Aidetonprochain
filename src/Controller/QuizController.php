<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("aide-ton-prochain/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/", name="quiz_index", methods={"GET"})
     * @param QuizRepository $quizRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(QuizRepository $quizRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $date = new \DateTime();
        $quizzes = $quizRepository->findAllByDate($date);

        $pagination = $paginator->paginate(
            $quizzes ,
            $request->query->getInt('page', 1), 8
        );

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $pagination
        ]);
    }

    /**
     * @Route("/creation/quiz", name="quiz_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $quiz = new Quiz();
        $user=$this->getUser();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $quiz->setUser($user);
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="quiz_show", methods={"GET"})
     * @param Quiz $quiz
     * @return Response
     */
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="quiz_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == quiz.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Quiz $quiz
     * @return Response
     */
    public function edit(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="quiz_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user == quiz.getUser()", message="Cette annonce ne vous appartient pas , vous ne pouvez pas la modifier")
     * @param Request $request
     * @param Quiz $quiz
     * @return Response
     */
    public function delete(Request $request, Quiz $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quiz_index');
    }
}
