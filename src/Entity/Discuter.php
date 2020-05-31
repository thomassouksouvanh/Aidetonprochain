<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscuterRepository")
 */
class Discuter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "L'identifiant doit avoir au moins {{ limit }} charactères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *    message = "Votre lien '{{ value }}' n'est pas valide",
     * )
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"nom"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le sujet doit avoir au moins {{ limit }} charactères"
     * )
     */
    private $sujet;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="discuters")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
