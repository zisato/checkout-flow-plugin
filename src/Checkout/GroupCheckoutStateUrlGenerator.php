<?php

namespace Jrc\CheckoutFlowPlugin\Checkout;

use Sylius\Bundle\CoreBundle\Checkout\CheckoutStateUrlGeneratorInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Routing\RequestContext;
use Sylius\Bundle\CoreBundle\Checkout\CheckoutStateUrlGenerator;

/**
 * Description of GroupCheckoutStateUrlGenerator
 *
 * @author javierrodriguez
 */
final class GroupCheckoutStateUrlGenerator implements CheckoutStateUrlGeneratorInterface
{
    /**
     * @var CheckoutStateUrlGenerator
     */
    private $checkoutStateUrlGenerator;
    
    /**
     * @var ChannelContextInterface
     */
    private $channelContext;
    
    /**
     * @var array
     */
    private $groupedRouteCollection;
    
    /**
     * @param CheckoutStateUrlGenerator $checkoutStateUrlGenerator
     * @param ChannelContextInterface $channelContext
     * @param array $groupedRouteCollection
     */
    public function __construct(
        CheckoutStateUrlGeneratorInterface $checkoutStateUrlGenerator, 
        ChannelContextInterface $channelContext,
        array $groupedRouteCollection
    ) {
        $this->checkoutStateUrlGenerator = $checkoutStateUrlGenerator;
        $this->channelContext = $channelContext;
        $this->groupedRouteCollection = $groupedRouteCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(
        $name, 
        $parameters = [], 
        $referenceType = self::ABSOLUTE_PATH
    ): string {
        return $this->checkoutStateUrlGenerator->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function generateForCart(
        array $parameters = [], 
        int $referenceType = self::ABSOLUTE_PATH
    ): string {
        $checkoutFlow = $this->channelContext->getChannel()->getCheckoutFlow();
        if (isset($this->groupedRouteCollection[$checkoutFlow]['empty_order']['route'])) {
            return $this->generate(
                $this->groupedRouteCollection[$checkoutFlow]['empty_order']['route'], 
                $parameters, 
                $referenceType
            );
        }

        return $this->checkoutStateUrlGenerator->generateForCart($parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function generateForOrderCheckoutState(
        OrderInterface $order, 
        array $parameters = [], 
        int $referenceType = self::ABSOLUTE_PATH
    ): string {
        $checkoutFlow = $order->getChannel()->getCheckoutFlow();
        $checkoutState = $order->getCheckoutState();
        
        if (isset($this->groupedRouteCollection[$checkoutFlow][$checkoutState]['route'])) {
            return $this->generate(
                $this->groupedRouteCollection[$checkoutFlow][$checkoutState]['route'],
                $parameters, 
                $referenceType
            );
        }
        
        return $this->checkoutStateUrlGenerator->generateForOrderCheckoutState(
            $order, 
            $parameters, 
            $referenceType
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getContext(): RequestContext
    {
        return $this->checkoutStateUrlGenerator->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->checkoutStateUrlGenerator->setContext($context);
    }
}
