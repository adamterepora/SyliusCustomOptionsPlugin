<?php
declare(strict_types=1);

namespace Tests\Brille24\CustomerOptionsPlugin\Behat\Context\Shop;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionInterface;
use Brille24\CustomerOptionsPlugin\Entity\ProductInterface;
use Tests\Brille24\CustomerOptionsPlugin\Behat\Page\Product\ShowPage;
use Webmozart\Assert\Assert;

class ProductContext implements Context
{
    /** @var ShowPage  */
    private $showPage;

    public function __construct(
        ShowPage $showPage
    )
    {
        $this->showPage = $showPage;
    }

    /**
     * @When I view product :product
     * @When I view product :product in the :localeCode locale
     */
    public function iViewProduct(ProductInterface $product, string $localeCode = 'en_US')
    {
        $this->showPage->open([
            'slug' => $product->getTranslation($localeCode)->getSlug(), '_locale' => $localeCode
        ]);
    }

    /**
     * @Then I should see customization for :customerOption
     */
    public function iShouldSeeCustomizationFor(CustomerOptionInterface $customerOption)
    {
        Assert::true($this->showPage->hasCustomizationFor($customerOption));
    }

    /**
     * @When I select no value for customer option :customerOption
     * @When I enter no value for customer option :customerOption
     */
    public function iSelectNoValueForCustomerOption(CustomerOptionInterface $customerOption)
    {
        $this->showPage->fillCustomerOption($customerOption, '');
    }

    /**
     * @When I select value :value for customer option :customerOption
     * @When I enter value :value for customer option :customerOption
     */
    public function iEnterValueForCustomerOption(string $value, CustomerOptionInterface $customerOption)
    {
        $this->showPage->fillCustomerOption($customerOption, $value);
    }

    /**
     * @When I add it to the cart
     */
    public function iAddItToTheCart()
    {
        $this->showPage->addToCart();
    }

    /**
     * @Then I should be notified that an option is required
     */
    public function iShouldBeNotifiedThatAnOptionIsRequired()
    {
        Assert::true($this->showPage->hasRequiredCustomerOptionValidationMessage());
    }

    /**
     * @Then I should be notified that an option is invalid
     */
    public function iShouldBeNotifiedThatAnOptionIsInvalid()
    {
        Assert::true($this->showPage->hasInvalidCustomerOptionValidationMessage());
    }

    /**
     * @Then I should be notified that an option does not meet a constraint
     */
    public function iShouldBeNotifiedThatAnOptionDoesNotMeetAConstraint()
    {
        Assert::true($this->showPage->hasOptionOutOfBoundsValidationMessage());
    }
}