<?php

namespace Jrc\CheckoutFlowPlugin\EventListener;

use Jrc\CheckoutFlowPlugin\Repository\OrderRepository;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

/**
 * Description of CartUpdateListener
 *
 * @author javierrodriguez
 */
class CartUpdateListener
{   
    /**
     * @var OrderRepository
     */
    protected $orderRepository;
    
    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    
    /**
     * @param ResourceControllerEvent $event
     */
    public function onChannelUpdate(ResourceControllerEvent $event)
    {
        $this->orderRepository->updateOrdersCheckoutStateToCart($event->getSubject());
    }
}
