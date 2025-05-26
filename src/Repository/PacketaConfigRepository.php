<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusPacketaPlugin\Repository;

use Doctrine\ORM\NoResultException;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use ThreeBRS\SyliusPacketaPlugin\Entity\PacketaConfigInterface;

class PacketaConfigRepository extends EntityRepository implements PacketaConfigRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function findOneEnabled(): ?PacketaConfigInterface
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->from(ShippingMethodInterface::class, 'sm')
            ->innerJoin('sm.packetaConfig', 'c')
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
