<?php

declare(strict_types=1);

namespace App\Interfaces;

interface GalleryEntityInterface
{
    public function getId(): ?int;

    public function getTitle(): ?string;

    public function setTitle(?string $title): GalleryEntityInterface;

    public function getImageName(): string;

    public function setImageName(string $imageName): GalleryEntityInterface;
}
