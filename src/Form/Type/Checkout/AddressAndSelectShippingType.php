<?php

namespace Jrc\CheckoutFlowPlugin\Form\Type\Checkout;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of AddressAndSelectShippingType
 *
 * @author masto
 */
class AddressAndSelectShippingType extends AbstractResourceType
{   
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', AddressType::class, [
                'label' => false,
                'inherit_data' => true,
                'customer' => $options['customer'],
            ])
            ->add('shipments', CollectionType::class, [
                'entry_type' => ShipmentType::class,
                'label' => false,
            ])
        ;
        
        // from https://github.com/symfony/symfony/issues/8834#issuecomment-55785696
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $child = $event->getForm()->get('address');
            $child->getConfig()->getEventDispatcher()->dispatch(
                FormEvents::PRE_SET_DATA,
                new FormEvent($child, $event->getData())
            );
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'customer' => null,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_checkout_address_select_shipping';
    }
}
