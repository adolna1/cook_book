<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserConfigRepository")
 */
class UserConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Recipes", inversedBy="users")
     */
    private $favouruteRecipes;

    public function __construct()
    {
        $this->favouruteRecipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Recipes[]
     */
    public function getFavouruteRecipes(): Collection
    {
        return $this->favouruteRecipes;
    }

    public function addFavouruteRecipe(Recipes $favouruteRecipe): self
    {
        if (!$this->favouruteRecipes->contains($favouruteRecipe)) {
            $this->favouruteRecipes[] = $favouruteRecipe;
        }

        return $this;
    }

    public function removeFavouruteRecipe(Recipes $favouruteRecipe): self
    {
        if ($this->favouruteRecipes->contains($favouruteRecipe)) {
            $this->favouruteRecipes->removeElement($favouruteRecipe);
        }

        return $this;
    }
}
