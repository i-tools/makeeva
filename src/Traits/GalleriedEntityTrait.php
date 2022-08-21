<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entity\Aroma;
use App\Entity\Stone;
use App\Interfaces\GalleryEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait GalleriedEntityTrait
{
    private Collection $gallery;

    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    /**
     * @return Aroma|Stone|GalleriedEntityTrait
     */
    public function setGallery(ArrayCollection $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Aroma|Stone|GalleriedEntityTrait
     */
    public function addGallery(GalleryEntityInterface $galleryEntity): self
    {
        $this->gallery->add($galleryEntity);

        return $this;
    }

    /**
     * @return Aroma|Stone|GalleriedEntityTrait
     */
    public function removeGallery(GalleryEntityInterface $galleryEntity): self
    {
        $this->gallery->removeElement($galleryEntity);

        return $this;
    }
}
