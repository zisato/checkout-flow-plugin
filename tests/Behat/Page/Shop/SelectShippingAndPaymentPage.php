<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class SelectShippingAndPaymentPage extends SymfonyPage implements SelectShippingAndPaymentPageInterface
{
    public function getRouteName()
    {
        return 'sylius_shop_checkout_select_shipping_and_payment';
    }

    public function nextStep()
    {
        $this->getElement('next_step')->press();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'next_step' => '#next-step',
        ]);
    }
}
