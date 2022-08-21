<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entity\Aroma;
use App\Entity\Page;
use App\Entity\Planet;
use App\Entity\Section;
use App\Entity\Stone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait HTMLPageTrait
{
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $published;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2, max: 255,
        minMessage: 'Field must be at least {{ limit }} characters long"',
        maxMessage: 'Field cannot be longer than {{ limit }} characters'
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $slug = null;

    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return Aroma|Page|Planet|Section|Stone|HTMLPageTrait
     */
    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return Aroma|Page|Planet|Section|Stone|HTMLPageTrait
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Aroma|Page|Planet|Section|Stone|HTMLPageTrait
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return Aroma|Page|Planet|Section|Stone|HTMLPageTrait
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Aroma|Page|Planet|Section|Stone|HTMLPageTrait
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
