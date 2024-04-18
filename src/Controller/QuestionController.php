<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/', name :'home')]
    public function homePage(): Response
    {
        return $this->render('question/index.html.twig');
    }
    
    #[Route('/questions', name: 'series_of_questions')]
    public function index(QuestionRepository $questionRepository): Response
    {
        // Récupérer toutes les questions depuis le repository
        $questions = $questionRepository->findAll();

        $serie = [];
        
        $count = count($questions);

        for ($i = 1; $i <= 10; $i++) {
            $number = random_int(1, $count);
            $serie[] = $questions[$number-1];
        }
         
        // Passer les questions au template pour l'affichage
        return $this->render('question/serie.html.twig', [
            'serie' => $serie,
        ]);
    }
    
    #[Route('/question' , name: 'random_question')]
    public function showRandomQuestion(): Response
    {

    }
}