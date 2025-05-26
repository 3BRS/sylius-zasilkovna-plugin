<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\ThreeBRS\SyliusPacketaPlugin\Behat\Page\Admin\ShippingMethod\UpdatePageInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingShippingMethodContext implements Context
{
    public function __construct(private UpdatePageInterface $updatePage)
    {
    }

    /**
     * @When /^I change Packeta Sender label to "([^"]*)"$/
     */
    public function iChangePacketaSenderLabelTo($arg1): void
    {
        $this->updatePage->changeInput('senderLabel', $arg1);
    }

    /**
     * @Then /^the Packeta Sender label for this shipping method should be "([^"]*)"$/
     */
    public function thePacketaSenderLabelForThisShippingMethodShouldBe($arg1): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('senderLabel'), $arg1);
    }

    /**
     * @When /^I change Packeta Carrier pickup point to "([^"]*)"$/
     */
    public function iChangePacketaCarrierIdTo($arg1): void
    {
        $this->updatePage->changeInput('carrierId', $arg1);
    }

    /**
     * @Then /^the Packeta Carrier pickup point for this shipping method should be "([^"]*)"$/
     */
    public function thePacketaCarrierIdForThisShippingMethodShouldBe($arg1): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('carrierId'), $arg1);
    }

    /**
     * @When /^I change Packeta api key to "([^"]*)"$/
     */
    public function iChangePacketaApiKeyTo(string $apiKey): void
    {
        $this->updatePage->changeApiKey($apiKey);
    }

    /**
     * @Then /^the Packeta api key for this shipping method should be "([^"]*)"$/
     */
    public function thePacketaApiKeyForThisShippingMethodShouldBe(string $apiKey): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('apiKey'), $apiKey);
    }

    /**
     * @Then it should be shipped to Packeta branch
     */
    public function itShouldBeShippedToPacketaBranch(): void
    {
        Assert::true($this->updatePage->iSeePacketaBranchInsteadOfShippingAddress());
    }
}
