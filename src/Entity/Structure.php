<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Un nom est requis')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Minimum {{ limit }} caractères',
        maxMessage: 'Maximum {{ limit }} caractères',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Une adresse est requise')]
    #[Assert\Length(
        min: 3,
        max: 200,
        minMessage: 'Minimum {{ limit }} caractères',
        maxMessage: 'Maximum {{ limit }} caractères',
    )]
    private ?string $adress = null;

    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Une adresse email est requise')]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas valide', 
    )]
    private ?string $manager = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: User::class, cascade: ['persist'] ,orphanRemoval: true)]
    private Collection $structure;


   

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Permission::class,cascade: ['persist'] ,orphanRemoval: true)]
    private Collection $permissions;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'mystructure')]
    private ?Partner $partner = null;

    

    public function __construct()
    {
        $this->structure = new ArrayCollection();
        $this->permissions = new ArrayCollection();
       
        
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
        $slug = (new Slugify())->slugify($this->name); 
        $this -> setSlug($slug);
        

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getStructure(): Collection
    {
        return $this->structure;
    }

    public function addStructure(User $structure): self
    {
        if (!$this->structure->contains($structure)) {
            $this->structure->add($structure);
            $structure->setStructure($this);
        }

        return $this;
    }

    public function removeStructure(User $structure): self
    {
        if ($this->structure->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getStructure() === $this) {
                $structure->setStructure(null);
            }
        }
 
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Permission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
            $permission->setService($this);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getService() === $this) {
                $permission->setService(null);
            }
        }

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }
    
}
