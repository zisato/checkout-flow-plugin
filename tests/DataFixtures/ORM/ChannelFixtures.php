<?php

namespace Tests\Jrc\CheckoutFlowPlugin\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Jrc\CheckoutFlowPlugin\Entity\Channel;
use Sylius\Component\Currency\Model\Currency;
use Sylius\Component\Locale\Model\Locale;

class ChannelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $currency = $this->generateCurrencies($manager);
        $locale = $this->generateLocales($manager);
        
        $this->generateChannels($manager, $currency, $locale);
    }
    
    protected function generateChannels(ObjectManager $manager, $currency, $locale)
    {   
        $entity = new Channel();
        $entity->setCode('WEB');
        $entity->setName('Web Channel');
        $entity->setHostname('localhost');
        $entity->setDescription('Lorem ipsum');
        $entity->setBaseCurrency($currency);
        $entity->setDefaultLocale($locale);
        $entity->setTaxCalculationStrategy("order_items_based");
        $entity->setColor("black");
        $entity->setEnabled(true);
        
        $manager->persist($entity);
        $manager->flush();
    }
    
    protected function generateCurrencies(ObjectManager $manager)
    {
        $entity = new Currency();
        $entity->setCode('EUR');
        
        $manager->persist($entity);
        $manager->flush();
        
        return $entity;
    }
    
    protected function generateLocales(ObjectManager $manager)
    {
        $entity = new Locale();
        $entity->setCode('en_US');
        
        $manager->persist($entity);
        $manager->flush();
        
        return $entity;
    }
}
