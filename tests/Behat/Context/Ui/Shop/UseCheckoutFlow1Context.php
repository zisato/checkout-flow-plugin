<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Behat\Page\Shop\Checkout\AddressPageInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop\PaymentAndCompletePageInterface;

/**
 * @author javierrodriguez
 */
final class UseCheckoutFlow1Context implements Context
{    
    /**
     * @var AddressPageInterface
     */
    private $addressPage;
    
    /**
     * @var PaymentAndCompletePageInterface
     */
    private $paymentAndCompletePage;
    
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;
    
    /**
     * @param AddressPageInterface $addressPage
     * @param PaymentAndCompletePageInterface $paymentAndCompletePage
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(
        AddressPageInterface $addressPage,
        PaymentAndCompletePageInterface $paymentAndCompletePage,
        SharedStorageInterface $sharedStorage
    ) {
        $this->addressPage = $addressPage;
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
     * @When I specified email :email
     */
    public function iSpecifiedEmail($email)
    {
        $this->addressPage->specifyEmail($email);
    }

    /**
     * @Then I should be on the payment and complete step
     */
    public function iShouldBeOnThePaymentAndCompleteStep()
    {
        $this->paymentAndCompletePage->verify();
    }
}
