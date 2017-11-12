<?php

namespace Jrc\CheckoutFlowPlugin\Checkout;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class GroupCheckoutResolver implements EventSubscriberInterface
{    
    /**
     * @var RequestMatcherInterface
     */
    private $requestMatcher;
    
    /**
     * @var CartContextInterface 
     */
    private $cartContext;
    
    /**
     * @var ChannelContextInterface
     */
    private $channelContext;

    /**
     * @var array
     */
    private $groupedFlowRoutes;
    
    /**
     * @param RequestMatcherInterface $requestMatcher
     * @param CartContextInterface $cartContext
     * @param ChannelContextInterface $channelContext
     * @param array $groupedFlowRoutes
     */
    public function __construct(
        RequestMatcherInterface $requestMatcher,
        CartContextInterface $cartContext,
        ChannelContextInterface $channelContext,
        array $groupedFlowRoutes
    ) {
        $this->requestMatcher = $requestMatcher;
        $this->cartContext = $cartContext;
        $this->channelContext = $channelContext;
        $this->groupedFlowRoutes = $groupedFlowRoutes;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        
        $request = $event->getRequest();

        if (!$this->requestMatcher->matches($request)) {
            return;
        }
        
        $route = $request->attributes->get('_route');
        $checkoutFlow = $this->channelContext->getChannel()->getCheckoutFlow();
        $routes = $this->groupedFlowRoutes[$checkoutFlow];

        if (array_search($route, $routes) === false) {
            $message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());
            throw new NotFoundHttpException($message);
        }
        
        return;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
