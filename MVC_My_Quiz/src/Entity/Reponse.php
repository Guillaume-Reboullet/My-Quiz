<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idQuestion = null;

    #[ORM\Column]
    private ?string $reponse = null;

    #[ORM\Column]
    private ?int $reponseExpected = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getIdQuestion(): ?int
    {
        return $this->idQuestion;
    }

    public function setIdQuestion(int $idQuestion): static
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }

    public function getReponseExpected(): ?int
    {
        return $this->reponseExpected;
    }

    public function setReponseExpected(int $reponseExpected): static
    {
        $this->reponseExpected = $reponseExpected;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }
}
