<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

interface ZasilkovnaConfigRepositoryInterface extends RepositoryInterface
{
    public function findOneEnabled(): ?ZasilkovnaConfigInterface;
}
