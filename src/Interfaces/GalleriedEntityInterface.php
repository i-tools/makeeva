<?php

declare(strict_types=1);

namespace App\Interfaces;

interface GalleriedEntityInterface
{
    public function getId(): ?int;
    public function getTitle(): ?string;
    public function setTitle(?string $title): GalleriedEntityInterface;
    public function getImageName(): string;
    public function setImageName(string $imageName): GalleriedEntityInterface;
}