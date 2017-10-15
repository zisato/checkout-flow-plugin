<?php

namespace Jrc\CheckoutFlowPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration
 *
 * @author javierrodriguez
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jrc_checkout_flow_plugin');
        
        $rootNode
            ->children()
                ->arrayNode('sm_paths')
                    ->scalarPrototype()
                    ->defaultValue([])
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }
}
