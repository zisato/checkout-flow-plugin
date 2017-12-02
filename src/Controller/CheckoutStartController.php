<?php

namespace Jrc\CheckoutFlowPlugin\Controller;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Description of CheckoutStartController
 *
 * @author javierrodriguez
 */
final class CheckoutStartController
{   
    /**
     * @var ChannelContextInterface 
     */
    private $channelContext;
    
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    
    /**
     * @var array
     */
    private $routeMap;
    
    /**
     * @param ChannelContextInterface $channelContext
     * @param array $routeMap
     */
    public function __construct(
        ChannelContextInterface $channelContext, 
        UrlGeneratorInterface $router,
        array $routeMap
    ) {
        $this->routeMap = $routeMap;
        $this->router = $router;
        $this->channelContext = $channelContext;
    }
    
    public function redirectAction(Request $request, $route)
    {        
        $channel = $this->channelContext->getChannel();
        $checkoutFlow = $channel->getCheckoutFlow();

        if (isset($this->routeMap[$checkoutFlow]['cart']['route'])) {
            $route = $this->routeMap[$checkoutFlow]['cart']['route'];
        }
        
        $attributes = $request->attributes->get('_route_params');
        unset($attributes['route'], $attributes['permanent'], $attributes['ignoreAttributes']);
        
        return new RedirectResponse($this->router->generate($route, $attributes, UrlGeneratorInterface::ABSOLUTE_URL));
    }
}
