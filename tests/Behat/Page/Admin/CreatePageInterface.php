<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\PageInterface;

interface CreatePageInterface extends PageInterface
{
    /**
     * @return void
     */
    public function chooseCheckoutFlow($checkoutFlow);
}
