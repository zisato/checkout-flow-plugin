<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;
use Sylius\Component\Core\Model\AddressInterface;

class AddressAndShippingPage extends SymfonyPage implements AddressAndShippingPageInterface
{
    public function getRouteName()
    {
        return 'sylius_shop_checkout_address_and_select_shipping';
    }

    public function nextStep()
    {
        $this->getElement('next_step')->press();
    }
    
    public function specifyShippingAddress(AddressInterface $address)
    {   
        $this->getElement('shipping_street')->setValue($address->getStreet());
        $this->getElement('shipping_city')->setValue($address->getCity());
        $this->getElement('shipping_postcode')->setValue($address->getPostcode());
        $this->getElement('shipping_country')->setValue($address->getCountryCode());
        $this->getElement('shipping_first_name')->setValue($address->getFirstName());
        $this->getElement('shipping_last_name')->setValue($address->getLastName());
    }
    
    public function specifyEmail($email)
    {
        $this->getElement('customer_email')->setValue($email);
    }

    public function selectShippingMethod($shippingMethod)
    {
        if ($this->getDriver() instanceof Selenium2Driver) {
            $this->getElement('shipping_method_select', ['%shipping_method%' => $shippingMethod])->click();

            return;
        }

        $shippingMethodOptionElement = $this->getElement('shipping_method_option', ['%shipping_method%' => $shippingMethod]);
        $shippingMethodOptionElement->selectOption($shippingMethodOptionElement->getAttribute('value'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_email' => '#sylius_checkout_address_select_shipping_address_customer_email',
            'next_step' => '#next-step',
            'shipping_city' => '#sylius_checkout_address_select_shipping_address_shippingAddress_city',
            'shipping_country' => '#sylius_checkout_address_select_shipping_address_billingAddress_countryCode',
            'shipping_first_name' => '#sylius_checkout_address_select_shipping_address_shippingAddress_firstName',
            'shipping_last_name' => '#sylius_checkout_address_select_shipping_address_shippingAddress_lastName',
            'shipping_postcode' => '#sylius_checkout_address_select_shipping_address_shippingAddress_postcode',
            'shipping_street' => '#sylius_checkout_address_select_shipping_address_shippingAddress_street',
            'shipping_method_select' => '.item:contains("%shipping_method%") > .field > .ui.radio.checkbox',
            'shipping_method_option' => '.item:contains("%shipping_method%") input',
        ]);
    }
}
