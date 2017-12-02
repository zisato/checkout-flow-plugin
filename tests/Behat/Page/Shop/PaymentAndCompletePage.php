<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class PaymentAndCompletePage extends SymfonyPage implements PaymentAndCompletePageInterface
{
    public function getRouteName()
    {
        return 'sylius_shop_checkout_select_payment_and_complete';
    }

    /**
     * {@inheritdoc}
     */
    public function selectPaymentMethod($paymentMethod)
    {
        if ($this->getDriver() instanceof Selenium2Driver) {
            $this->getElement('payment_method_select', ['%payment_method%' => $paymentMethod])->click();

            return;
        }

        $paymentMethodOptionElement = $this->getElement('payment_method_option', ['%payment_method%' => $paymentMethod]);
        $paymentMethodOptionElement->selectOption($paymentMethodOptionElement->getAttribute('value'));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'payment_method_option' => '.item:contains("%payment_method%") input',
            'payment_method_select' => '.item:contains("%payment_method%") > .field > .ui.radio.checkbox',
        ]);
    }
}
