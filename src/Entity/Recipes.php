<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipesRepository")
 */
class Recipes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecipyIngradients", mappedBy="recipe", cascade={"persist"})
     */
    private $recipyIngradients;

    public function __construct()
    {
        $this->recipyIngradients = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|RecipyIngradients[]
     */
    public function getRecipyIngradients(): Collection
    {
        return $this->recipyIngradients;
    }

    public function addRecipyIngradient(RecipyIngradients $recipyIngradient): self
    {
        if (!$this->recipyIngradients->contains($recipyIngradient)) {
            $this->recipyIngradients[] = $recipyIngradient;
            $recipyIngradient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipyIngradient(RecipyIngradients $recipyIngradient): self
    {
        if ($this->recipyIngradients->contains($recipyIngradient)) {
            $this->recipyIngradients->removeElement($recipyIngradient);
            // set the owning side to null (unless already changed)
            if ($recipyIngradient->getRecipe() === $this) {
                $recipyIngradient->setRecipe(null);
            }
        }

        return $this;
    }
}
