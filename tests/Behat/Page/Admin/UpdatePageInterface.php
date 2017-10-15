<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
    /**
     * @param string $checkoutFlow
     * @return void
     */
    public function chooseCheckoutFlow($checkoutFlow);
    
    /**
     * @param string $checkoutFlow
     * @return bool
     */
    public function isCheckoutFlowChosen($checkoutFlow);
}
