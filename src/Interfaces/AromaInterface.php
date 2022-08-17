<?php

namespace App\Interfaces;

interface AromaInterface
{
    public function getPlanet(): ?PlanetInterface;
    public function setPlanet(?PlanetInterface $planet): self;
    public function getImageName(): ?string;
    public function setImageName(?string $imageName): self;
}