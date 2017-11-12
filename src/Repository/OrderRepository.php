<?php

namespace Jrc\CheckoutFlowPlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutStates;

/**
 * Description of OrderRepository
 *
 * @author javierrodriguez
 */
class OrderRepository extends BaseOrderRepository
{
    public function updateOrdersCheckoutStateToCart($channel)
    {
        $orders = $this->createQueryBuilder('o')
            ->select('o.id')
            ->innerJoin('o.channel', 'channel')
            ->where('channel.id = :channel')
            ->andWhere('o.state = :state')
            ->andWhere('o.checkoutState != :checkoutState')
            ->setParameter('channel', $channel)
            ->setParameter('state', OrderInterface::STATE_CART)
            ->setParameter('checkoutState', OrderCheckoutStates::STATE_CART)
            ->getQuery()
            ->getResult()
        ;
        
        $ordersId = array_map(function($value) {
            return $value['id'];
        }, $orders);
        
        $this->createQueryBuilder('o')
            ->update()
            ->set('o.checkoutState', ':newCheckoutState')
            ->andWhere('o.id IN (:ordersId)')
            ->setParameter('ordersId', $ordersId)
            ->setParameter('newCheckoutState', OrderCheckoutStates::STATE_CART)
            ->getQuery()
            ->getResult()
        ;
    }
}
