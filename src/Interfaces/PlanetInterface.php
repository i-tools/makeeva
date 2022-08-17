<?php

declare(strict_types=1);

namespace App\Interfaces;

use Doctrine\Common\Collections\Collection;

interface PlanetInterface
{
    public function getId(): ?int;
    public function getImageName(): ?string;
    public function setImageName(?string $imageName): PlanetInterface;
    public function getDescription(): ?string;
    public function setDescription(string $description): PlanetInterface;
    public function getStones(): Collection;
    public function setStones(Collection $stones): PlanetInterface;
    public function addStone(StoneInterface ...$stones): PlanetInterface;
    public function removeStone(StoneInterface $stone): PlanetInterface;
    public function getAromas(): Collection;
    public function setAromas(Collection $aromas): PlanetInterface;
    public function addAroma(AromaInterface ...$aromas): PlanetInterface;
    public function removeAroma(AromaInterface $aroma): PlanetInterface;
}