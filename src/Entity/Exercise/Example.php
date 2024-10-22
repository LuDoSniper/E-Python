<?php

namespace App\Entity\Exercise;

use App\Repository\Exercise\ExampleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExampleRepository::class)]
class Example
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToOne(targetEntity: Exercise::class, inversedBy: 'example_ids')]
    private Collection $exercise;

    // Construct

    public function __construct()
    {
        $this->exercise = new ArrayCollection();
    }

    // Getter - Setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExerciseId(): Collection
    {
        return $this->exercise;
    }
    public function addExerciseId(Exercise $exerciseId): static
    {
        if (!$this->exercise->contains($exerciseId)) {
            $this->exercise->add($exerciseId);
            $exerciseId->setExampleIds($this);
        }

        return $this;
    }
    public function removeExerciseId(Exercise $exerciseId): static
    {
        if ($this->exercise->removeElement($exerciseId)) {
            // set the owning side to null (unless already changed)
            if ($exerciseId->getExampleIds() === $this) {
                $exerciseId->setExampleIds(null);
            }
        }

        return $this;
    }
}
