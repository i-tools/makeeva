<?php

namespace App\Traits;

use App\Entity\Stone;
use App\Interfaces\GalleryEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nette\Utils\Strings;

trait GalleriedEntityTrait
{
    private Collection $gallery;

    public static function getEntityClass(): string
    {
        // By default, the translatable class has the same name but without the "Translation" suffix
        return Strings::substring(static::class, 0, -11);
    }

    /**
     * @return Collection
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    /**
     * @param ArrayCollection $gallery
     * @return GalleriedEntityTrait|Stone
     */
    public function setGallery(ArrayCollection $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @param GalleryEntityInterface $galleryEntity
     * @return GalleriedEntityTrait|Stone
     */
    public function addGallery(GalleryEntityInterface $galleryEntity): self
    {
        $this->gallery->add($galleryEntity);

        return $this;
    }

    /**
     * @param GalleryEntityInterface $galleryEntity
     * @return GalleriedEntityTrait|Stone
     */
    public function removeGallery(GalleryEntityInterface $galleryEntity): self
    {
        $this->gallery->removeElement($galleryEntity);

        return $this;
    }
}