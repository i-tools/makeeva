<?php

namespace App\Interfaces;

interface PlanetInterface
{
    public function getId(): ?int;
    public function getTitle(): ?string;
    public function setTitle(string $title): PlanetInterface;
    public function getDescription(): ?string;
    public function setDescription(string $description): PlanetInterface;
    public function getContent(): ?string;
    public function setContent(?string $content): PlanetInterface;
    public function getSlug(): ?string;
    public function setSlug(string $slug): PlanetInterface;
}