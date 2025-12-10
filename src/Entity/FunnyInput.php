<?php

namespace App\Entity;

use App\Repository\FunnyInputRepository;
use App\Validator\Input;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: FunnyInputRepository::class)]
class FunnyInput
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Feld darf nicht leer sein')]
    #[Assert\Length(min: 1, max: 255,
        minMessage: "Das Feld muss mindestens 1 Zeichen lang sein.",
        maxMessage: "Das Feld darf maximal 255 Zeichen lang sein")]
    #[Input]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[NotBlank(message: 'Feld darf nicht leer sein')]
    #[Assert\Type(DateTimeInterface::class, message: 'Feld muss ein datum sein')]
    #[Assert\GreaterThan("today", message: 'Datum muss in der Zukunft liegen')]
    private ?\DateTime $date = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Feld darf nicht leer sein')]
    #[Assert\Type(type: Types::INTEGER, message: "Der Wert muss eine gültige Zahl sein")]
    #[Assert\GreaterThan(2, message: '67')]
    private ?int $funnyNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getFunnyNumber(): ?int
    {
        return $this->funnyNumber;
    }

    public function setFunnyNumber(int $funnyNumber): static
    {
        $this->funnyNumber = $funnyNumber;

        return $this;
    }
}
