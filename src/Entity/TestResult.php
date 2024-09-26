<?php

namespace App\Entity;

use App\Repository\TestResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestResultRepository::class)]
class TestResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $completedAt = null;

    #[ORM\Column]
    private array $correctAnswers = [];

    #[ORM\Column]
    private array $wrongAnswers = [];

    public function __construct()
    {
        $this->completedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompletedAt(): ?\DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTimeInterface $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getCorrectAnswers(): array
    {
        return $this->correctAnswers;
    }

    public function setCorrectAnswers(array $correctAnswers): static
    {
        $this->correctAnswers = $correctAnswers;

        return $this;
    }

    public function getWrongAnswers(): array
    {
        return $this->wrongAnswers;
    }

    public function setWrongAnswers(array $wrongAnswers): static
    {
        $this->wrongAnswers = $wrongAnswers;

        return $this;
    }
}
