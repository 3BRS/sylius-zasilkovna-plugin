<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusZasilkovnaPlugin\Repository;

use Doctrine\ORM\NoResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use ThreeBRS\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

class ZasilkovnaConfigRepository extends EntityRepository implements ZasilkovnaConfigRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findOneEnabled(): ?ZasilkovnaConfigInterface
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->from(ShippingMethodInterface::class, 'sm')
            ->innerJoin('sm.zasilkovnaConfig', 'c')
            ->andWhere('c = e')
            ->andWhere('sm.enabled = true')
            ->andWhere('c.apiKey IS NOT NULL')
            ->setMaxResults(1)
        ;

        try {
            // @phpstan-ignore return.type
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException) {
            return null;
        }
    }
}
