<?php

namespace App\Entity;

use App\Repository\PermissionRepository;

use Doctrine\ORM\Mapping as ORM;

use PhpParser\Node\NullableType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = Null;

    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom doit être au moins de {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} characters',
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'permissions')]
    private ?Structure $service = null;

    

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getService(): ?Structure
    {
        return $this->service;
    }

    public function setService(?Structure $service): self
    {
        $this->service = $service;

        return $this;
    }

    
}
