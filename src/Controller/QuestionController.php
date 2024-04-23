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
        $questions = $questionRepository->findBy(['type' => 1]);

        $serie = [];
        
        $count = count($questions);

        $numbers = $this->generateRandomNumbers(1, $count, 10);
        foreach ($numbers as $number) {
            $serie[] = $questions[$number-1];
        }
         
        // Passer les questions au template pour l'affichage
        return $this->render('question/serie.html.twig', [
            'serie' => $serie,
        ]);
    }
    
    #[Route('/questions/mf2', name: 'series_of_questions_mf2')]
    public function mf2(QuestionRepository $questionRepository): Response
    {
        // Récupérer toutes les questions depuis le repository
        $questions = $questionRepository->findBy(['type' => 2]);

        $serie = [];
        
        $count = count($questions);

        $numbers = $this->generateRandomNumbers(1, $count, 10);
        foreach ($numbers as $number) {
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
    
    function generateRandomNumbers($min, $max, $count) {
    if ($max - $min + 1 < $count) {
        throw new Exception("Impossible de générer autant de nombres uniques dans la plage spécifiée.");
    }

    $numbers = [];
    while (count($numbers) < $count) {
        $randomNumber = rand($min, $max);
        if (!in_array($randomNumber, $numbers)) {
            $numbers[] = $randomNumber;
        }
    }

    return $numbers;
}
}