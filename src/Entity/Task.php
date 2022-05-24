<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
/**
 * @UniqueEntity(fields="title",  message="Le titre '{{ value }}' existe déja !")

 */
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\Length(min="5",max="20",minMessage="Le nom doit faire au minimum 5 caractères",maxMessage="Le titre ne doit pas dépasser 50 caractères")
     *@Assert\Regex(
     *     pattern="/[a-zA-Z0-9._\p{L}-]{1,20}/",
     *     message="le titre n'est pas valide"
     * )
     * @Assert\NotBlank(message = "Le titre est obligatoire.")
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $title;

    /**
     * 
     * @Assert\NotBlank(message = "Le contenu est obligatoire.")
     * @Assert\Regex(
     *     pattern="/[a-zA-Z0-9._\p{L}-]{1,20}/",
     *     message="Vérifier votre contenu"
     * )
     * @Assert\Length(min="10",minMessage="Le contenu doit faire au minimum 10 caractères")
     */
    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'boolean')]
    private $isDone;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    private $users;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->isDone;
    }
    //set it 
    public function toggle(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
