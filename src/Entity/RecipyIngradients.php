<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipyIngradientsRepository")
 */
class RecipyIngradients
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ingradients", inversedBy="recipyIngradients")
     */
    private $ingradient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipes", inversedBy="recipyIngradients")
     */
    private $recipe;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $measurment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngradient(): ?ingradients
    {
        return $this->ingradient;
    }

    public function setIngradient(?ingradients $ingradient): self
    {
        $this->ingradient = $ingradient;

        return $this;
    }

    public function getRecipe(): ?recipes
    {
        return $this->recipe;
    }

    public function setRecipe(?recipes $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getMeasurment(): ?float
    {
        return $this->measurment;
    }

    public function setMeasurment(?float $measurment): self
    {
        $this->measurment = $measurment;

        return $this;
    }
}
