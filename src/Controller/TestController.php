<?php

namespace App\Controller;

use App\Entity\TestResult;
use App\Repository\QuestionRepository;
use App\Repository\TestResultRepository;
use App\Service\QuizService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    /**
     * @param QuizService $quizService
     */
    public function __construct(private readonly QuizService $quizService)
    {
    }

    /**
     * @param  QuestionRepository $questionRepository
     * @return Response
     */
    #[Route('/test', name: 'test')]
    public function test(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAll();
        return $this->render(
            'test.html.twig', [
            'questions' => $questions,
            ]
        );
    }

    /**
     * @param  Request                $request
     * @param  QuestionRepository     $questionRepository
     * @param  EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/test/submit', name: 'test_submit', methods: ['POST'])]
    public function submit(
        Request $request,
        QuestionRepository $questionRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $answers = $request->request->all();
        $correctAnswers = [];
        $wrongAnswers = [];

        foreach ($answers as $questionId => $userAnswers) {
            $question = $questionRepository->find($questionId);
            if (!$question) {
                continue;
            }

            if (count($userAnswers) === 1) {
                $wrongAnswers[] = $question->getText();
                continue;
            } else {
                unset($userAnswers[0]);
            }

            $correctAnswerIds = [];
            foreach ($question->getAnswers() as $answer) {
                if ($answer->isCorrect()) {
                    $correctAnswerIds[] = $answer->getId();
                }
            }

            if ($this->quizService->checkUserAnswers($correctAnswerIds, $userAnswers)) {
                $correctAnswers[] = $question->getText();
            } else {
                $wrongAnswers[] = $question->getText();
            }
        }

        $testResult = new TestResult();
        $testResult->setCorrectAnswers($correctAnswers);
        $testResult->setWrongAnswers($wrongAnswers);
        $entityManager->persist($testResult);
        $entityManager->flush();

        return $this->render(
            'result.html.twig', [
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            ]
        );
    }
}