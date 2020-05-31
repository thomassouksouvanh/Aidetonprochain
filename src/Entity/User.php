<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 * @UniqueEntity(fields={"email"}, message="Cette adresse Email est déjà utilisée")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le nom doit avoir au moins {{ limit }} charactères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le prénom doit avoir au moins {{ limit }} charactères"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"nom","prenom"})
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="avatar")
     * @var File|null
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage ="Veuillez télécharger aux formats png,jpg ou jpeg",
     *     maxSize="2M",
     *     maxSizeMessage = "Fichier trop volumineux"
     * )

     */
    private $avatarFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var File|null
     *
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * * @var DateTimeImmutable
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="user")
     */
    private $annonces;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", mappedBy="user")
     */
    private $propositions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Discuter", mappedBy="user")
     */
    private $discuters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Diy", mappedBy="user")
     */
    private $diys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entreprise", mappedBy="user")
     */
    private $entreprises;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="user")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gaming", mappedBy="user")
     */
    private $gamings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Information", mappedBy="user")
     */
    private $information;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Initiative", mappedBy="user")
     */
    private $initiatives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quiz", mappedBy="user")
     */
    private $quizzes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Streaming", mappedBy="user")
     */
    private $streamings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="user")
     */
    private $videos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="profil", orphanRemoval=true)
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;

    /**
     * @ORM\OneToMany(targetEntity=Concour::class, mappedBy="author")
     */
    private $concours;


    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->propositions = new ArrayCollection();
        $this->discuters = new ArrayCollection();
        $this->diys = new ArrayCollection();
        $this->entreprises = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->gamings = new ArrayCollection();
        $this->information = new ArrayCollection();
        $this->initiatives = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
        $this->streamings = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->concours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return "{$this->nom} {$this->prenom}";
    }

    /**
     * A visual identifier that represents this test.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every test at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the test, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    /**
     * @param File|null $avatarFile
     * @throws \Exception
     */
    public function setAvatarFile(?File $avatarFile = null)
    {
        $this->avatarFile = $avatarFile;
        if (null !== $avatarFile) {
            $this->updateAt = new DateTimeImmutable();
        }
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([$this->id,
                          $this->email,
                          $this->password,
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        [
            $this->id,
            $this->email,
            $this->password,
        ] = unserialize($serialized, array('allowed_classes' => false));
    }


    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions[] = $proposition;
            $proposition->setUser($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): self
    {
        if ($this->propositions->contains($proposition)) {
            $this->propositions->removeElement($proposition);
            // set the owning side to null (unless already changed)
            if ($proposition->getUser() === $this) {
                $proposition->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Discuter[]
     */
    public function getDiscuters(): Collection
    {
        return $this->discuters;
    }

    public function addDiscuter(Discuter $discuter): self
    {
        if (!$this->discuters->contains($discuter)) {
            $this->discuters[] = $discuter;
            $discuter->setUser($this);
        }

        return $this;
    }

    public function removeDiscuter(Discuter $discuter): self
    {
        if ($this->discuters->contains($discuter)) {
            $this->discuters->removeElement($discuter);
            // set the owning side to null (unless already changed)
            if ($discuter->getUser() === $this) {
                $discuter->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Diy[]
     */
    public function getDiys(): Collection
    {
        return $this->diys;
    }

    public function addDiy(Diy $diy): self
    {
        if (!$this->diys->contains($diy)) {
            $this->diys[] = $diy;
            $diy->setUser($this);
        }

        return $this;
    }

    public function removeDiy(Diy $diy): self
    {
        if ($this->diys->contains($diy)) {
            $this->diys->removeElement($diy);
            // set the owning side to null (unless already changed)
            if ($diy->getUser() === $this) {
                $diy->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Entreprise[]
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setUser($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprises->contains($entreprise)) {
            $this->entreprises->removeElement($entreprise);
            // set the owning side to null (unless already changed)
            if ($entreprise->getUser() === $this) {
                $entreprise->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setUser($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getUser() === $this) {
                $formation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Gaming[]
     */
    public function getGamings(): Collection
    {
        return $this->gamings;
    }

    public function addGaming(Gaming $gaming): self
    {
        if (!$this->gamings->contains($gaming)) {
            $this->gamings[] = $gaming;
            $gaming->setUser($this);
        }

        return $this;
    }

    public function removeGaming(Gaming $gaming): self
    {
        if ($this->gamings->contains($gaming)) {
            $this->gamings->removeElement($gaming);
            // set the owning side to null (unless already changed)
            if ($gaming->getUser() === $this) {
                $gaming->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Information[]
     */
    public function getInformation(): Collection
    {
        return $this->information;
    }

    public function addInformation(Information $information): self
    {
        if (!$this->information->contains($information)) {
            $this->information[] = $information;
            $information->setUser($this);
        }

        return $this;
    }

    public function removeInformation(Information $information): self
    {
        if ($this->information->contains($information)) {
            $this->information->removeElement($information);
            // set the owning side to null (unless already changed)
            if ($information->getUser() === $this) {
                $information->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Initiative[]
     */
    public function getInitiatives(): Collection
    {
        return $this->initiatives;
    }

    public function addInitiative(Initiative $initiative): self
    {
        if (!$this->initiatives->contains($initiative)) {
            $this->initiatives[] = $initiative;
            $initiative->setUser($this);
        }

        return $this;
    }

    public function removeInitiative(Initiative $initiative): self
    {
        if ($this->initiatives->contains($initiative)) {
            $this->initiatives->removeElement($initiative);
            // set the owning side to null (unless already changed)
            if ($initiative->getUser() === $this) {
                $initiative->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quiz[]
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setUser($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->contains($quiz)) {
            $this->quizzes->removeElement($quiz);
            // set the owning side to null (unless already changed)
            if ($quiz->getUser() === $this) {
                $quiz->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Streaming[]
     */
    public function getStreamings(): Collection
    {
        return $this->streamings;
    }

    public function addStreaming(Streaming $streaming): self
    {
        if (!$this->streamings->contains($streaming)) {
            $this->streamings[] = $streaming;
            $streaming->setUser($this);
        }

        return $this;
    }

    public function removeStreaming(Streaming $streaming): self
    {
        if ($this->streamings->contains($streaming)) {
            $this->streamings->removeElement($streaming);
            // set the owning side to null (unless already changed)
            if ($streaming->getUser() === $this) {
                $streaming->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

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

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @param mixed $profil
     */
    public function setProfil($profil): void
    {
        $this->profil = $profil;
    }

    /**
     * @param User $author
     * @return comment | null
     * permet de récupérer un commentaire par rapport a un auteur
     */
    public function getCommentFromAuthor(User $author) {
        foreach ( $this->comments as $value) {
            if ($value->getAuthor() === $author) {
                return $value;
            }
            return null;
        }
    }

    /**
     * @return Collection|Concour[]
     */
    public function getConcours(): Collection
    {
        return $this->concours;
    }

    public function addConcour(Concour $concour): self
    {
        if (!$this->concours->contains($concour)) {
            $this->concours[] = $concour;
            $concour->setAuthor($this);
        }

        return $this;
    }

    public function removeConcour(Concour $concour): self
    {
        if ($this->concours->contains($concour)) {
            $this->concours->removeElement($concour);
            // set the owning side to null (unless already changed)
            if ($concour->getAuthor() === $this) {
                $concour->setAuthor(null);
            }
        }

        return $this;
    }
}
