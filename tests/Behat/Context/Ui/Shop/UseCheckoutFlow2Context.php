<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Behat\Page\Shop\Checkout\AddressPageInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop\SelectShippingAndPaymentPageInterface;

/**
 * @author javierrodriguez
 */
final class UseCheckoutFlow2Context implements Context
{    
    /**
     * @var AddressPageInterface
     */
    private $addressPage;
    
    /**
     * @var SelectShippingAndPaymentPageInterface
     */
    private $selectShippingAndPaymentPage;
    
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;
    
    /**
     * @param AddressPageInterface $addressPage
     * @param SelectShippingAndPaymentPageInterface $selectShippingAndPaymentPage
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(
        AddressPageInterface $addressPage,
        SelectShippingAndPaymentPageInterface $selectShippingAndPaymentPage,
        SharedStorageInterface $sharedStorage
    ) {
        $this->addressPage = $addressPage;
        $this->selectShippingAndPaymentPage = $selectShippingAndPaymentPage;
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
     * @When I complete the shipping and payment step
     */
    public function iCompleteTheShippingAndPaymentStep()
    {
        $this->selectShippingAndPaymentPage->nextStep();
    }
}
