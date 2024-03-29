<?php

namespace App\Entity;


use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'partner', targetEntity: User::class)]
    private Collection $user;

    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Un nom est requis')]
    #[Assert\Length(
        min: 3,
        max: 150,
        minMessage: 'Minimum {{ limit }} caractères',
        maxMessage: 'Maximum {{ limit }} caractères',
    )]
    private ?string $name = null;

    
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\NotBlank(message: 'Une adresse email est requise')]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas valide', 
    )]
    #[ORM\Column(length: 255)]
    private ?string $ComContact = null;

    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $website = null;

    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Une adresse email est requise')]
    #[Assert\Email(
        message: 'L\'email {{ value }} n\'est pas valide', 
    )]
    private ?string $ManageContact = null;

    #[Assert\NotBlank(message: 'Saisissez une ville')]
    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'partner', targetEntity: Structure::class)]
    private Collection $mystructure;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->mystructure = new ArrayCollection();
        
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setPartner($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPartner() === $this) {
                $user->setPartner(null);
            }
        }

        return $this;
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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getComContact(): ?string
    {
        return $this->ComContact;
    }

    public function setComContact(string $ComContact): self
    {
        $this->ComContact = $ComContact;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getManageContact(): ?string
    {
        return $this->ManageContact;
    }

    public function setManageContact(string $ManageContact): self
    {
        $this->ManageContact = $ManageContact;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getMystructure(): Collection
    {
        return $this->mystructure;
    }

    public function addMystructure(Structure $mystructure): self
    {
        if (!$this->mystructure->contains($mystructure)) {
            $this->mystructure->add($mystructure);
            $mystructure->setPartner($this);
        }

        return $this;
    }

    public function removeMystructure(Structure $mystructure): self
    {
        if ($this->mystructure->removeElement($mystructure)) {
            // set the owning side to null (unless already changed)
            if ($mystructure->getPartner() === $this) {
                $mystructure->setPartner(null);
            }
        }

        return $this;
    }
}
