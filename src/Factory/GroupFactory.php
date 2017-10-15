<?php

namespace Jrc\CheckoutFlowPlugin\Factory;

use SM\Callback\CallbackFactoryInterface;
use SM\Factory\Factory;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Description of GroupFactory
 *
 * @author javierrodriguez
 */
class GroupFactory extends Factory
{   
    /**
     * @var array
     */
    protected $checkoutConfigs;
    
    /**
     * @param array $configs
     * @param EventDispatcherInterface $dispatcher
     * @param CallbackFactoryInterface $callbackFactory
     * @param array $checkoutConfigs
     */
    public function __construct(
        array $configs, 
        EventDispatcherInterface $dispatcher = null, 
        CallbackFactoryInterface $callbackFactory = null,
        array $checkoutConfigs = []
    ) {
        parent::__construct($configs, $dispatcher, $callbackFactory);
        
        $this->checkoutConfigs = $checkoutConfigs;
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($object, $graph = 'default')
    {
        if ($object instanceof OrderInterface) {
            $checkoutFlow = $object->getChannel()->getCheckoutFlow();
            $newConfig = $this->checkoutConfigs[$checkoutFlow];
            
            foreach ($this->configs as $key => $config) {
                if ($config['graph'] === $newConfig['graph']) {
                    $this->configs[$key] = $newConfig;
                }
            }
        }
        
        return parent::get($object, $graph);
    }
}
