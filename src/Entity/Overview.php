<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OverviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OverviewRepository::class)]
class Overview implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $overviewAt = null;

    #[ORM\Column]
    private ?int $numberOfWeek = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $recommendations = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getOverviewAt(): ?\DateTimeImmutable
    {
        return $this->overviewAt;
    }

    public function setOverviewAt(\DateTimeImmutable $overviewAt): static
    {
        $this->overviewAt = $overviewAt;

        return $this;
    }

    public function getNumberOfWeek(): ?int
    {
        return $this->numberOfWeek;
    }

    public function setNumberOfWeek(int $numberOfWeek): static
    {
        $this->numberOfWeek = $numberOfWeek;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(string $recommendations): static
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'type' => $this->type,
            'overviewAt' => $this->overviewAt,
            'numberOfWeek' => $this->numberOfWeek,
            'status' => $this->status,
            'recommendations' => $this->recommendations,
            'phone' => $this->phone,
            'createdAt' => $this->createdAt,
        ];
    }
}
