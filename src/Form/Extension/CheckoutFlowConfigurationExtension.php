<?php

namespace Jrc\CheckoutFlowPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of CheckoutFlowConfigurationExtension
 *
 * @author javierrodriguez
 */
final class CheckoutFlowConfigurationExtension extends AbstractTypeExtension
{
    private $formChoices;
    
    public function __construct(array $formChoices)
    {        
        $this->formChoices = $formChoices;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('checkoutFlow', ChoiceType::class, [
                'choices' => $this->formChoices,
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ChannelType::class;
    }
}
