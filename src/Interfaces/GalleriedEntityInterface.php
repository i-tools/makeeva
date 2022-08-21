<?php

declare(strict_types=1);

namespace App\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

interface GalleriedEntityInterface
{
    public function getGallery(): Collection;

    public function setGallery(ArrayCollection $gallery): self;

    public function addGallery(GalleryEntityInterface $galleryEntity): self;

    public function removeGallery(GalleryEntityInterface $galleryEntity): self;
}
