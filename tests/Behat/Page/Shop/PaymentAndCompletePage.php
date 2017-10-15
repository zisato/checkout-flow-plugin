<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class PaymentAndCompletePage extends SymfonyPage implements PaymentAndCompletePageInterface
{
    public function getRouteName()
    {
        return 'sylius_shop_checkout_select_payment_and_complete';
    }
}
