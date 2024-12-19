<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
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
    private string $module;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professeur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $professeur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Classe", inversedBy="cours")
     * @ORM\JoinTable(name="cours_classe")
     */
    private Collection $classes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="cours")
     */
    private Collection $sessions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Niveau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;
        return $this;
    }

    public function getProfesseur()
    {
        return $this->professeur;
    }

    public function setProfesseur($professeur): self
    {
        $this->professeur = $professeur;
        return $this;
    }

    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasse($classe): self
    {
        if (!$this->classes->contains($classe)) {
            $this->classes[] = $classe;
        }
        return $this;
    }

    public function removeClasse($classe): self
    {
        $this->classes->removeElement($classe);
        return $this;
    }

    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession($session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCours($this);
        }
        return $this;
    }

    public function removeSession($session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getCours() === $this) {
                $session->setCours(null);
            }
        }
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
}