<?php

namespace Jrc\CheckoutFlowPlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

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
            ->andWhere('o.checkoutState NOT IN (:checkoutState)')
            ->setParameter('channel', $channel)
            ->setParameter('checkoutState', ['cart', 'addressed', 'completed'])
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
            ->setParameter('newCheckoutState', 'cart')
            ->getQuery()
            ->getResult()
        ;
    }
}
