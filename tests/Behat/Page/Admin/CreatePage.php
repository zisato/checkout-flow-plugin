<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin;

use Sylius\Behat\Behaviour\NamesIt;
use Sylius\Behat\Behaviour\SpecifiesItsCode;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

/**
 * @author javierrodriguez
 */
class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use NamesIt;
    use SpecifiesItsCode;

    public function chooseCheckoutFlow($checkoutFlow)
    {
        $this->getDocument()->selectFieldOption('Checkout flow', $checkoutFlow);
    }

    /**
     * {@inheritdoc}
     */
    public function chooseBaseCurrency($currency)
    {
        if (null !== $currency) {
            $this->getElement('currencies')->selectOption($currency);
            $this->getElement('base_currency')->selectOption($currency);
        }
    }
    
    public function chooseDefaultLocale($locale)
    {
        if (null !== $locale) {
            $this->getElement('locales')->selectOption($locale);
            $this->getElement('default_locale')->selectOption($locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'checkout_flow' => '#sylius_channel_checkoutFlow',
            'code' => '#sylius_channel_code',
            'currencies' => '#sylius_channel_currencies',
            'base_currency' => '#sylius_channel_baseCurrency',
            'default_locale' => '#sylius_channel_defaultLocale',
            'locales' => '#sylius_channel_locales',
            'name' => '#sylius_channel_name',
        ]);
    }
}
