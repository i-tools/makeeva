<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\HTMLPageInterface;
use App\Repository\SectionRepository;
use App\Traits\HTMLPageTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

#[ORM\Table(name: 'sections')]
#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section implements HTMLPageInterface, TimestampableInterface
{
    use TimestampableTrait;
    use HTMLPageTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
