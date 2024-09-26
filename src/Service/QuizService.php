<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;

class QuizService
{
    function isCorrectAnswer(array $userAnswers, Question $question): bool
    {
        $correctAnswers = array_filter(
            $question->getAnswers()->toArray(),
            fn (Answer $answer) => $answer->isCorrect()
        );

        $correctAnswerIds = array_map(fn (Answer $answer) => $answer->getId(), $correctAnswers);

        sort($userAnswers);
        sort($correctAnswerIds);

        return $userAnswers === $correctAnswerIds;
    }
}