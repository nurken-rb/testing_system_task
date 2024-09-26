<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAll();
        return $this->render('test.html.twig', [
            'questions' => $questions,
        ]);
    }
}