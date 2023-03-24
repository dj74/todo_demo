<?php

namespace App\Entity;

use App\Repository\TodoItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoItemRepository::class)]
class TodoItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $creation_ts = null;

    #[ORM\Column(nullable: true)]
    private ?int $start_ts = null;

    #[ORM\Column(nullable: true)]
    private ?int $completed_ts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // added. compromise the strictness
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreationTs(): ?int
    {
        return $this->creation_ts;
    }

    public function setCreationTs(int $creation_ts): self
    {
        $this->creation_ts = $creation_ts;

        return $this;
    }

    public function getStartTs(): ?int
    {
        return $this->start_ts;
    }

    public function setStartTs(?int $start_ts): self
    {
        $this->start_ts = $start_ts;

        return $this;
    }

    public function getCompletedTs(): ?int
    {
        return $this->completed_ts;
    }

    public function setCompletedTs(?int $completed_ts): self
    {
        $this->completed_ts = $completed_ts;

        return $this;
    }
}
