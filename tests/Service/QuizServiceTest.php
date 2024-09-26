<?php

namespace App\Tests\Service;

use App\Service\QuizService;
use PHPUnit\Framework\TestCase;

class QuizServiceTest extends TestCase
{
    private QuizService $quizService;

    protected function setUp(): void
    {
        $this->quizService = new QuizService();
    }

    public function testCheckUserAnswersCorrect()
    {
        $correctAnswerIds = [83, 84];
        $userAnswers = [83, 84];

        $result = $this->quizService->checkUserAnswers($correctAnswerIds, $userAnswers);
        $this->assertTrue($result, 'Ответы должны совпадать');
    }

    public function testCheckUserAnswersIncorrect()
    {
        $correctAnswerIds = [83, 84];
        $userAnswers = [83];

        $result = $this->quizService->checkUserAnswers($correctAnswerIds, $userAnswers);
        $this->assertFalse($result, 'Ответы не должны совпадать');
    }

    public function testCheckUserAnswersWithDifferentOrder()
    {
        $correctAnswerIds = [83, 84];
        $userAnswers = [84, 83];

        $result = $this->quizService->checkUserAnswers($correctAnswerIds, $userAnswers);
        $this->assertTrue($result, 'Ответы должны совпадать независимо от порядка');
    }

    public function testCheckUserAnswersEmpty()
    {
        $correctAnswerIds = [83, 84];
        $userAnswers = [];

        $result = $this->quizService->checkUserAnswers($correctAnswerIds, $userAnswers);
        $this->assertFalse($result, 'Пустые ответы должны вернуть false');
    }
}
