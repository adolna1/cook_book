<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngradientsRepository")
 */
class Ingradients
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RecipyIngradients", mappedBy="ingradient")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $recipyIngradient->setIngradient($this);
        }

        return $this;
    }

    public function removeRecipyIngradient(RecipyIngradients $recipyIngradient): self
    {
        if ($this->recipyIngradients->contains($recipyIngradient)) {
            $this->recipyIngradients->removeElement($recipyIngradient);
            // set the owning side to null (unless already changed)
            if ($recipyIngradient->getIngradient() === $this) {
                $recipyIngradient->setIngradient(null);
            }
        }

        return $this;
    }
}
