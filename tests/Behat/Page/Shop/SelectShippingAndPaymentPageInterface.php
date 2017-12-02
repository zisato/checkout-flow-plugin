<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\PageInterface;

interface SelectShippingAndPaymentPageInterface extends PageInterface
{
    public function nextStep();
    
    public function selectShippingMethod($shippingMethod);
    
    public function selectPaymentMethod($paymentMethod);
}
