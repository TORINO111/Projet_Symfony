<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClasseRepository")
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Niveau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", mappedBy="classes")
     */
    private Collection $cours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etudiant", mappedBy="classe")
     */
    private Collection $etudiants;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function setNiveau($niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCours($cours): self
    {
        if (!$this->cours->contains($cours)) {
            $this->cours[] = $cours;
        }
        return $this;
    }

    public function removeCours($cours): self
    {
        $this->cours->removeElement($cours);
        return $this;
    }

    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant($etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setClasse($this);
        }
        return $this;
    }

    public function removeEtudiant($etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getClasse() === $this) {
                $etudiant->setClasse(null);
            }
        }
        return $this;
    }
}