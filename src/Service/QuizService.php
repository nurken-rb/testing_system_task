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
        sort($userAnswers);
        if (empty($userAnswers)) {
            return false;
        }
        if ($correctAnswerIds == $userAnswers) {
            return true;
        }
        return false;
    }
}