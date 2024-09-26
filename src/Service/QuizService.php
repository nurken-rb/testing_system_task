<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;

class QuizService
{
    /**
     * @param  array $correctAnswerIds
     * @param  array $userAnswers
     * @return bool
     */
    public function checkUserAnswers(array $correctAnswerIds, array $userAnswers): bool
    {
        if (empty($userAnswers)) {
            return false;
        }
        $userAnswers = array_map('intval', $userAnswers);
        sort($userAnswers);
        return $correctAnswerIds == $userAnswers;
    }
}