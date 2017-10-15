<?php

namespace Jrc\CheckoutFlowPlugin\Form\Type\Checkout;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ChangePaymentMethodType;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\PaymentType;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * Description of SelectShippingAndPaymentType
 *
 * @author masto
 */
class SelectShippingAndPaymentType extends AbstractResourceType
{   
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shipments', CollectionType::class, [
                'entry_type' => ShipmentType::class,
                'label' => false,
            ])
            ->add('payments', ChangePaymentMethodType::class, [
                'entry_type' => PaymentType::class,
                'label' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_checkout_select_shipping_payment';
    }
}
