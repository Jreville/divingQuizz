<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class AdminController extends AbstractController
{
    #[Route('/admin/questions', name: 'admin_questions')]
    public function index(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    #[Route('/admin/question/new', name: 'admin_question_new')]
    public function new(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($question);
            $entityManager->flush();
            
            return $this->redirectToRoute('admin_questions');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/question/{id}/edit', name: 'admin_question_edit')]
    public function edit(Request $request, PersistenceManagerRegistry $doctrine, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('admin_questions');
        }

        return $this->render('admin/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/question/{id}', name: 'admin_question_delete', methods: ['DELETE'])]
    public function delete(Request $request, PersistenceManagerRegistry $doctrine, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_questions');
    }
}
