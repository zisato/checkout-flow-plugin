<?php

namespace Jrc\CheckoutFlowPlugin\Entity;

use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * Description of Channel
 *
 * @author javierrodriguez
 */
class Channel extends BaseChannel
{
    /**
     * @var string
     */
    private $checkoutFlow;

    /**
     * @return string
     */
    public function getCheckoutFlow()
    {
        return $this->checkoutFlow;
    }

    /**
     * @param string $checkoutFlow
     */
    public function setCheckoutFlow($checkoutFlow)
    {
        $this->checkoutFlow = $checkoutFlow;
    }
}
