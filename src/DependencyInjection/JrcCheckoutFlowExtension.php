<?php

namespace Jrc\CheckoutFlowPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;
use winzou\Bundle\StateMachineBundle\DependencyInjection\winzouStateMachineExtension;

/**
 * Description of JrcCheckoutFlowExtension
 *
 * @author javierrodriguez
 */
final class JrcCheckoutFlowExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {   
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $smPaths = array_merge([__DIR__.'/../Resources/config/app/state_machine'], $config['sm_paths']);
        $smConfigs = $this->parseFilesToArray($smPaths);
        
        $checkoutConfigs = $this->getCheckoutConfigs($smConfigs);
        $container->setParameter('jrc.checkout_flow_plugin.sm_configs', $checkoutConfigs);
        
        $routeMapConfigs = $this->getRouteMapConfigs($smConfigs);
        $container->setParameter('jrc.checkout_flow_plugin.route_map', $routeMapConfigs);
        
        $formChoiceConfigs = $this->getFormChoiceConfig($smConfigs);
        $container->setParameter('jrc.checkout_flow_plugin.sm_configs_choices', $formChoiceConfigs);
    }
    
    protected function parseFilesToArray(array $paths): array
    {
        $finder = Finder::create();
        $finder->files()->name('*.yml')->in($paths);
        $result = [];
        
        foreach ($finder as $file) {
            $content = Yaml::parse($file->getContents());
            $key = key($content);
            
            $result[$key] = $content[$key];
        }
        
        return $result;
    }

    protected function getCheckoutConfigs($configs): array
    {   
        $contents = [];
        $keys = [];
        
        foreach ($configs as $key => $config) {
            $stateMachine = $config['state_machine'];
            
            $this->setDefaultValue($stateMachine, 'callbacks', []);
            $this->setDefaultValue($stateMachine['callbacks'], 'after', []);
            $this->setDefaultValue($stateMachine['callbacks'], 'before', []);
            $this->setDefaultValue($stateMachine['callbacks'], 'guard', []);
            
            foreach ($stateMachine['callbacks']['after'] as &$callback) {
                $this->setDefaultValue($callback, 'disabled', false);
                $this->setDefaultValue($callback, 'priority', 0);
            }
            
            $contents[] = $stateMachine;
            $keys[] = $key;
        }

        $winzou = new winzouStateMachineExtension();
        $parsedConfig = $winzou->parseConfig($contents);
        
        return array_combine($keys, $parsedConfig);
    }
    
    public function getRouteMapConfigs($configs): array
    {  
        $result = [];
        foreach ($configs as $key => $config) {
            $result[$key] = $config['route_map'];
        }
        
        return $result;
    }
    
    public function getFormChoiceConfig($configs): array
    {  
        $result = [];
        foreach ($configs as $key => $config) {
            $result[$config['choice_label']] = $key;
        }
        
        return $result;
    }
    
    protected function setDefaultValue(array &$array, $key, $value)
    {
        if (!isset($array[$key])) {
            $array[$key] = $value;
        }
    }
}
