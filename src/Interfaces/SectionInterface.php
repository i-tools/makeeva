<?php

declare(strict_types=1);

namespace App\Interfaces;

use Doctrine\Common\Collections\Collection;

interface SectionInterface
{
    public function getPages(): Collection;

    public function setPages(Collection $pages): self;

    public function addPage(PageInterface ...$pages): self;

    public function removePage(PageInterface $page): self;
}
