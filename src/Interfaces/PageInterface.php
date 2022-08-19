<?php

declare(strict_types=1);

namespace App\Interfaces;

interface PageInterface
{
    public function getSection(): ?SectionInterface;
    public function setSection(?SectionInterface $section): PageInterface;
}