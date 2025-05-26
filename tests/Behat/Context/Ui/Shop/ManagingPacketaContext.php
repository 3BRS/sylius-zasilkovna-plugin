<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutShippingContext;
use Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Page\Shop\Packeta\PacketaPagesInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingPacketaContext implements Context
{
    public function __construct(
        private PacketaPagesInterface   $packetaPages,
        private CheckoutShippingContext $checkoutShippingContext,
    ) {
    }

    /**
     * @Then I should not be able to go to the payment step again
     */
    public function iShouldNotBeAbleToGoToThePaymentStepAgain()
    {
        Assert::throws(function () {
            $this->checkoutShippingContext->iShouldBeAbleToGoToThePaymentStepAgain();
        }, UnexpectedPageException::class);
    }

    /**
     * @Then I select :packetaName Packeta branch
     */
    public function iSelectPacketaBranch(string $packetaName)
    {
        $this->packetaPages->selectPacketaBranch(['id' => 1, 'place' => $packetaName]);
    }

    /**
     * @Given I see Packeta branch instead of shipping address
     */
    public function iSeePacketaBranchInsteadOfShippingAddress()
    {
        Assert::true($this->packetaPages->iSeePacketaBranchInsteadOfShippingAddress());
    }
}
