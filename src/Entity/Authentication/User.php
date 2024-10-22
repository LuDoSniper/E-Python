<?php

namespace App\Entity\Authentication;

use App\Entity\Exercise\Exercise;
use App\Repository\Authentication\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainpassword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $display_name = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'user_ids')]
    private Collection $exercise_ids;


    #[ORM\Column]
    private ?array $roles = [];

    // Construct

    public function __construct()
    {
        $this->exercise_ids = new ArrayCollection();
    }

    // Getter - Setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }
    public function setDisplayName(?string $display_name): static
    {
        $this->display_name = $display_name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainpassword(): ?string
    {
        return $this->plainpassword;
    }
    public function setPlainpassword(?string $plainpassword): void
    {
        $this->plainpassword = $plainpassword;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExerciseIds(): Collection
    {
        return $this->exercise_ids;
    }
    public function addExerciseId(Exercise $exerciseId): static
    {
        if (!$this->exercise_ids->contains($exerciseId)) {
            $this->exercise_ids->add($exerciseId);
            $exerciseId->addUserId($this);
        }
        return $this;
    }
    public function removeExerciseId(Exercise $exerciseId): static
    {
        if ($this->exercise_ids->removeElement($exerciseId)) {
            $exerciseId->removeUserId($this);
        }
        return $this;
    }

    public function addRole(string $role): static
    {
        if (!in_array($role, $this->getRoles())){
            $this->roles[] = $role;
        }
        return $this;
    }
    public function removeRole(string $role): static
    {
        if (in_array($role, $this->getRoles())){
            $this->roles = array_values(array_diff($this->getRoles(), [$role]));
        }
        return $this;
    }

    // Methods

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
         $this->setPlainpassword(null);
    }
}
