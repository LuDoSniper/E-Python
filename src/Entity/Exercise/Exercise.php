<?php

namespace App\Entity\Exercise;

use App\Entity\Authentication\User;
use App\Repository\Exercise\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'exercise_ids')]
    private Collection $user_ids;

    #[ORM\OneToMany(targetEntity: Example::class, mappedBy: 'exercise_id')]
    private ?Example $example_ids = null;

    public function __construct()
    {
        $this->user_ids = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserIds(): Collection
    {
        return $this->user_ids;
    }
    public function addUserId(User $userId): static
    {
        if (!$this->user_ids->contains($userId)) {
            $this->user_ids->add($userId);
        }
        return $this;
    }
    public function removeUserId(User $userId): static
    {
        $this->user_ids->removeElement($userId);
        return $this;
    }

    public function getExampleIds(): ?Example
    {
        return $this->example_ids;
    }

    public function setExampleIds(?Example $example_ids): static
    {
        $this->example_ids = $example_ids;

        return $this;
    }
}
