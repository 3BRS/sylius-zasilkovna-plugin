<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
    public function getSingleResourceFromPage(string $elementName): string|bool|array|null;

    public function changeApiKey(?string $apiKey): void;

    public function changeInput(string $elementName, ?string $value): void;

    public function getPacketaDownloadButton(): NodeElement;

    public function iSeePacketaBranchInsteadOfShippingAddress(): bool;
}
