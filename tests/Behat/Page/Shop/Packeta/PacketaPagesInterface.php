<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Page\Shop\Packeta;

use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface PacketaPagesInterface extends BaseUpdatePageInterface
{
    public function selectPacketaBranch(array $packeta): void;

    public function iSeePacketaBranchInsteadOfShippingAddress(): bool;
}
