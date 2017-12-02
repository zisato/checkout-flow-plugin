<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop\AddressAndShippingPageInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop\PaymentAndCompletePageInterface;

/**
 * @author javierrodriguez
 */
final class UseCheckoutFlow3Context implements Context
{    
    /**
     * @var AddressAndShippingPageInterface
     */
    private $addressAndShippingPage;
    
    /**
     * @var PaymentAndCompletePageInterface
     */
    private $paymentAndCompletePage;
    
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;
    
    /**
     * @param AddressAndShippingPageInterface $addressAndShippingPage
     * @param PaymentAndCompletePageInterface $paymentAndCompletePage
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(
        AddressAndShippingPageInterface $addressAndShippingPage,
        PaymentAndCompletePageInterface $paymentAndCompletePage,
        SharedStorageInterface $sharedStorage
    ) {
        $this->addressAndShippingPage = $addressAndShippingPage;
        $this->paymentAndCompletePage = $paymentAndCompletePage;
        $this->sharedStorage = $sharedStorage;
    }
    
    /**
     * @Given the store has checkout flow :checkoutFlow
     */
    public function theStoreHasCheckoutFlow($checkoutFlow)
    {
        $channel = $this->sharedStorage->get('channel');
        $channel->setCheckoutFlow($checkoutFlow);
        
        $this->sharedStorage->set('channel', $channel);
    }
    
    /**
     * @Given I am at the checkout addressing and select shipping step
     */
    public function iAmAtTheCheckoutAddressingAndSelectShippingStep()
    {
        $this->addressAndShippingPage->open();
    }

    /**
     * @When /^I specify the shipping (address as "[^"]+", "[^"]+", "[^"]+", "[^"]+" for "[^"]+")$/
     */
    public function iSpecifiedAddressAsFor(AddressInterface $address)
    {
        $this->addressAndShippingPage->specifyShippingAddress($address);
    }

    /**
     * @When I specified email :email
     */
    public function iSpecifiedEmail($email)
    {
        $this->addressAndShippingPage->specifyEmail($email);
    }

    /**
     * @When I select :shippingMethod shipping method
     */
    public function iSelectShippingMethod($shippingMethod)
    {
        $this->addressAndShippingPage->selectShippingMethod($shippingMethod);
    }

    /**
     * @When I complete the addressing and select shipping step
     */
    public function iCompleteTheAddressingAndSelectShippingStep()
    {
        $this->addressAndShippingPage->nextStep();
    }
    
    /**
     * @Then I select :paymentMethod payment method
     */
    public function iSelectPaymentMethod($paymentMethod)
    {
        $this->paymentAndCompletePage->selectPaymentMethod($paymentMethod);
    }
    
    /**
     * @Then I should be on the checkout payment and complete step
     */
    public function iShouldBeOnTheCheckoutPaymentAndCompleteStep()
    {
        $this->paymentAndCompletePage->verify();
    }
}
