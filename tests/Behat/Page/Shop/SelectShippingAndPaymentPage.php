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

//    public function selectPaymentMethod($paymentMethod)
//    {
//        if ($this->getDriver() instanceof Selenium2Driver) {
//            $this->getElement('payment_method_select', ['%payment_method%' => $paymentMethod])->click();
//
//            return;
//        }
//
//        $paymentMethodOptionElement = $this->getElement('payment_method_option', ['%payment_method%' => $paymentMethod]);
//        $paymentMethodOptionElement->selectOption($paymentMethodOptionElement->getAttribute('value'));
//
//    }
//
//    public function selectShippingMethod($shippingMethod)
//    {
//        if ($this->getDriver() instanceof Selenium2Driver) {
//            $this->getElement('shipping_method_select', ['%shipping_method%' => $shippingMethod])->click();
//
//            return;
//        }
//
//        $shippingMethodOptionElement = $this->getElement('shipping_method_option', ['%shipping_method%' => $shippingMethod]);
//        $shippingMethodOptionElement->selectOption($shippingMethodOptionElement->getAttribute('value'));
//
//    }
    
    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
//            'payment_method_option' => '.item:contains("%payment_method%") input',
//            'payment_method_select' => '.item:contains("%payment_method%") > .field > .ui.radio.checkbox',
//            'shipping_method' => '[name="sylius_checkout_select_shipping[shipments][0][method]"]',
//            'shipping_method_fee' => '.item:contains("%shipping_method%") .fee',
//            'shipping_method_select' => '.item:contains("%shipping_method%") > .field > .ui.radio.checkbox',
//            'shipping_method_option' => '.item:contains("%shipping_method%") input',
            'next_step' => '#next-step',
        ]);
    }
}
