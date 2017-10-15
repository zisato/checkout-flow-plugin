<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;

/**
 * @author javierrodriguez
 */
class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    public function chooseCheckoutFlow($checkoutFlow)
    {
        $this->getDocument()->selectFieldOption('Checkout flow', $checkoutFlow);
    }

    public function isCheckoutFlowChosen($checkoutFlow)
    {
        return $this->getElement('checkout_flow')->find('named', ['option', $checkoutFlow])->hasAttribute('selected');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'checkout_flow' => '#sylius_channel_checkoutFlow'
        ]);
    }
}
