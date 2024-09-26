<?php

namespace App\Command;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'LoadQuestionsCommand',
    description: 'Load questions and answers into the database',
    aliases: ['load_questions'] ,
)]
class LoadQuestionsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $questionsData = [
            [
                'text' => '1 + 1 =',
                'answers' => [
                    ['text' => '2', 'is_correct' => true],
                    ['text' => '3', 'is_correct' => false],
                    ['text' => '0', 'is_correct' => false],
                ],
            ],
            [
                'text' => '2 + 2 =',
                'answers' => [
                    ['text' => '4', 'is_correct' => true],
                    ['text' => '3 + 1', 'is_correct' => true],
                    ['text' => '10', 'is_correct' => false],
                ],
            ],
            [
                'text' => '3 + 3 =',
                'answers' => [
                    ['text' => '1 + 5', 'is_correct' => true],
                    ['text' => '1', 'is_correct' => false],
                    ['text' => '6', 'is_correct' => true],
                    ['text' => '2+4', 'is_correct' => true],
                ]
            ],
            [
                'text' => '4 + 4 =',
                'answers' => [
                    ['text' => '8', 'is_correct' => true],
                    ['text' => '4', 'is_correct' => false],
                    ['text' => '0', 'is_correct' => false],
                    ['text' => '0 + 8', 'is_correct' => true],
                ]
            ],
            [
                'text' => '5 + 5 =',
                'answers' => [
                    ['text' => '6', 'is_correct' => false],
                    ['text' => '18', 'is_correct' => false],
                    ['text' => '10', 'is_correct' => true],
                    ['text' => '9', 'is_correct' => false],
                    ['text' => '0', 'is_correct' => false],
                ]
            ],
            [
                'text' => '6 + 6 =',
                'answers' => [
                    ['text' => '3', 'is_correct' => false],
                    ['text' => '9', 'is_correct' => false],
                    ['text' => '0', 'is_correct' => false],
                    ['text' => '12', 'is_correct' => true],
                    ['text' => '5 + 7', 'is_correct' => true],
                ]
            ],
            [
                'text' => '7 + 7 =',
                'answers' => [
                    ['text' => '5', 'is_correct' => false],
                    ['text' => '14', 'is_correct' => true],
                ]
            ],
            [
                'text' => '8 + 8 =',
                'answers' => [
                    ['text' => '16', 'is_correct' => true],
                    ['text' => '12', 'is_correct' => false],
                    ['text' => '9', 'is_correct' => false],
                    ['text' => '5', 'is_correct' => false],
                ]
            ]
        ];

        foreach ($questionsData as $data) {
            $question = new Question();
            $question->setText($data['text']);
            foreach ($data['answers'] as $answerData) {
                $answer = new Answer();
                $answer->setText($answerData['text']);
                $answer->setCorrect($answerData['is_correct']);
                $answer->setQuestion($question);
                $this->entityManager->persist($answer);
            }

            $this->entityManager->persist($question);
        }

        $this->entityManager->flush();

        $io->success('Questions and answers loaded successfully.');
        return Command::SUCCESS;
    }
}
