<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    public function changeInput(
        string  $elementName,
        ?string $value,
    ): void {
        $this->getElement($elementName)->setValue($value);
    }

    public function changeApiKey(?string $apiKey): void
    {
        $this->getElement('apiKey')->setValue($apiKey);
    }

    public function getSingleResourceFromPage(string $elementName): string|bool|array|null
    {
        return $this->getElement($elementName)->getValue();
    }

    public function getPacketaDownloadButton(): NodeElement
    {
        return $this->getElement('packetaDownloadButton');
    }

    public function iSeePacketaBranchInsteadOfShippingAddress(): bool
    {
        $shippingAddress = $this->getElement('shippingAddress')->getText();

        return str_contains($shippingAddress, 'Packeta branch');
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'apiKey'          => '#sylius_admin_shipping_method_packetaConfig_apiKey',
            'senderLabel'     => '#sylius_admin_shipping_method_packetaConfig_senderLabel',
            'carrierId'       => '#sylius_admin_shipping_method_packetaConfig_carrierId',
            'shippingAddress' => '[data-test-shipping-address]',
        ]);
    }
}
