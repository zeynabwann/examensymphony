<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClasse: Classe::class)]
#[ORM\Table(name: "client")]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Assert\NotBlank(message: "Le libelle de la classe ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 200,
        minMessage: "Le libelle doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le libelle ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $libelle = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Assert\NotBlank(message: "Le nom de la classe ne doit ps etre vide .")]
    #[Assert\Length(
        min: 4,
        max: 50,
        minMessage: "Le nom de la classe  doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom de la classe ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nomc = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: "le niveau ne peut pas être vide.")]
    private ?string $niveau = null;

    

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Cours::class, cascade: ['persist', 'remove'])]
    private Collection $cours;
    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: professeur::class, cascade: ['persist', 'remove'])]
    private Collection $professeur;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->professeur = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getCours(?string $cours): self
    {
        return $this->$cours;
    }

    public function setCours(?string $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function getProf(?string $prof): self
    {
        return $this->$prof;
    }

    public function setprof(?string $prof): self
    {
        $this->cours = $prof;

        return $this;
    }

}