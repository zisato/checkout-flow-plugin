<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\PageInterface;
use Sylius\Component\Core\Model\AddressInterface;

interface AddressAndShippingPageInterface extends PageInterface
{
    public function nextStep();
    
    public function specifyShippingAddress(AddressInterface $address);
    
    public function specifyEmail($email);
    
    public function selectShippingMethod($shippingMethod);
}
