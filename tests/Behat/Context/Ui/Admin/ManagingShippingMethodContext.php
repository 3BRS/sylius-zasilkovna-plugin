<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusZasilkovnaPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\ThreeBRS\SyliusZasilkovnaPlugin\Behat\Page\Admin\ShippingMethod\UpdatePageInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingShippingMethodContext implements Context
{
    public function __construct(private UpdatePageInterface $updatePage)
    {
    }
    /**
     * @When /^I change Zásilkovna Sender label to "([^"]*)"$/
     */
    public function iChangeZasilkovnaSenderLabelTo($arg1): void
    {
        $this->updatePage->changeInput('senderLabel', $arg1);
    }

    /**
     * @Then /^the Zásilkovna Sender label for this shipping method should be "([^"]*)"$/
     */
    public function theZasilkovnaSenderLabelForThisShippingMethodShouldBe($arg1): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('senderLabel'), $arg1);
    }

    /**
     * @When /^I change Zásilkovna Carrier pickup point to "([^"]*)"$/
     */
    public function iChangeZasilkovnaCarrierIdTo($arg1): void
    {
        $this->updatePage->changeInput('carrierId', $arg1);
    }

    /**
     * @Then /^the Zásilkovna Carrier pickup point for this shipping method should be "([^"]*)"$/
     */
    public function theZasilkovnaCarrierIdForThisShippingMethodShouldBe($arg1): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('carrierId'), $arg1);
    }

    /**
     * @When /^I change Zásilkovna api key to "([^"]*)"$/
     */
    public function iChangeZasilkovnaApiKeyTo(string $apiKey): void
    {
        $this->updatePage->changeApiKey($apiKey);
    }

    /**
     * @Then /^the Zásilkovna api key for this shipping method should be "([^"]*)"$/
     */
    public function theZasilkovnaApiKeyForThisShippingMethodShouldBe(string $apiKey): void
    {
        Assert::eq($this->updatePage->getSingleResourceFromPage('apiKey'), $apiKey);
    }

    /**
     * @Then it should be shipped to Zásilkovna branch
     */
    public function itShouldBeShippedToZasilkovnaBranch(): void
    {
        Assert::true($this->updatePage->iSeeZasilkovnaBranchInsteadOfShippingAddress());
    }
}
