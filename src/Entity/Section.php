<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PageInterface;
use App\Interfaces\SectionInterface;
use App\Repository\SectionRepository;
use App\Traits\HTMLPageTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Table(name: 'sections')]
#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section implements SectionInterface, HTMLPageInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Page::class, cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    private Collection $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @return Section
     */
    public function setPages(Collection $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function addPage(PageInterface ...$pages): self
    {
        foreach ($pages as $page) {
            if (!$this->pages->contains($page)) {
                $this->pages->add($page);
                $page->setSection($this);
            }
        }

        return $this;
    }

    public function removePage(PageInterface $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
        }

        return $this;
    }
}
