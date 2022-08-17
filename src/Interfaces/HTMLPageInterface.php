<?php

namespace App\Interfaces;

interface HTMLPageInterface
{
    public function isPublished(): bool;
    public function setPublished(bool $published): self;
    public function getTitle(): ?string;
    public function setTitle(?string $title): self;
    public function getContent(): ?string;
    public function setContent(?string $content): self;
    public function getSlug(): ?string;
    public function setSlug(?string $slug): self;
}