<?php

declare(strict_types=1);

namespace App\Interfaces;

interface StoneInterface
{
    public function getId(): ?int;

    public function isPublished(): bool;

    public function setPublished(bool $published): StoneInterface;

    public function getPlanet(): ?PlanetInterface;

    public function setPlanet(?PlanetInterface $planet): StoneInterface;

    public function getImageName(): ?string;

    public function setImageName(?string $imageName): StoneInterface;

    public function getTitle(): ?string;

    public function setTitle(string $title): StoneInterface;

    public function getContent(): ?string;

    public function setContent(?string $content): StoneInterface;

    public function getSlug(): ?string;

    public function setSlug(string $slug): StoneInterface;
}
