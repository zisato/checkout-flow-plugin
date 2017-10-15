<?php

namespace Tests\Jrc\CheckoutFlowPlugin\PHPUnit;

use Jrc\CheckoutFlowPlugin\GroupCheckoutStateUrlGenerator;
use Sylius\Bundle\CoreBundle\Checkout\CheckoutStateUrlGeneratorInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Jrc\CheckoutFlowPlugin\Entity\Channel;

/**
 * @author javierrodriguez
 */
class GroupCheckoutStateUrlGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public function testItShouldGenerateForCartFromGroupedConfig()
    {
        $expected = 'foo_route';
        
        $checkoutStateUrlGenerator = $this->getMockBuilder(CheckoutStateUrlGeneratorInterface::class)
            ->getMock();
        $channelContext = $this->getMockBuilder(ChannelContextInterface::class)
            ->getMock();
        $channel = $this->getMockBuilder(Channel::class)
            ->getMock();
        
        $checkoutStateUrlGenerator
            ->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($expected))
        ;
        $channel
            ->expects($this->once())
            ->method('getCheckoutFlow')
            ->will($this->returnValue('flow_1'))
        ;
        $channelContext
            ->expects($this->once())
            ->method('getChannel')
            ->will($this->returnValue($channel))
        ;
        
        $groupedConfig = [
            'flow_1' => [
                'empty_order' => [
                    'route' => $expected
                ]
            ]
        ];
        
        $object = new GroupCheckoutStateUrlGenerator($checkoutStateUrlGenerator, $channelContext, $groupedConfig);
        $result = $object->generateForCart();
        
        $this->assertEquals($expected, $result);
    }
    
    public function testItShouldGenerateForOrderCheckoutStateFromGroupedConfig()
    {
        $expected = 'foo_route';
        
        $checkoutStateUrlGenerator = $this->getMockBuilder(CheckoutStateUrlGeneratorInterface::class)
            ->getMock();
        $channelContext = $this->getMockBuilder(ChannelContextInterface::class)
            ->getMock();
        $channel = $this->getMockBuilder(Channel::class)
            ->getMock();
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        
        $checkoutStateUrlGenerator
            ->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($expected))
        ;
        $channel
            ->expects($this->once())
            ->method('getCheckoutFlow')
            ->will($this->returnValue('flow_1'))
        ;
        $order
            ->expects($this->once())
            ->method('getChannel')
            ->will($this->returnValue($channel))
        ;
        $order
            ->expects($this->once())
            ->method('getCheckoutState')
            ->will($this->returnValue('addressed'))
        ;
        
        $groupedConfig = [
            'flow_1' => [
                'addressed' => [
                    'route' => $expected
                ]
            ]
        ];
        
        $object = new GroupCheckoutStateUrlGenerator($checkoutStateUrlGenerator, $channelContext, $groupedConfig);
        $result = $object->generateForOrderCheckoutState($order);
        
        $this->assertEquals($expected, $result);
    }
    
    public function testItShouldGenerateForCartFromOriginalObject()
    {
        $expected = 'foo_route';
        
        $checkoutStateUrlGenerator = $this->getMockBuilder(CheckoutStateUrlGeneratorInterface::class)
            ->getMock();
        $channelContext = $this->getMockBuilder(ChannelContextInterface::class)
            ->getMock();
        $channel = $this->getMockBuilder(Channel::class)
            ->getMock();
        
        $checkoutStateUrlGenerator
            ->expects($this->once())
            ->method('generateForCart')
            ->will($this->returnValue($expected))
        ;
        $channel
            ->expects($this->once())
            ->method('getCheckoutFlow')
            ->will($this->returnValue('flow_1'))
        ;
        $channelContext
            ->expects($this->once())
            ->method('getChannel')
            ->will($this->returnValue($channel))
        ;
        
        $groupedConfig = [
            'flow_2' => [
                'empty_order' => [
                    'route' => $expected
                ]
            ]
        ];
        
        $object = new GroupCheckoutStateUrlGenerator($checkoutStateUrlGenerator, $channelContext, $groupedConfig);
        $result = $object->generateForCart();
        
        $this->assertEquals($expected, $result);
    }
    
    public function testItShouldGenerateForOrderCheckoutStateFromOriginalObject()
    {
        $expected = 'foo_route';
        
        $checkoutStateUrlGenerator = $this->getMockBuilder(CheckoutStateUrlGeneratorInterface::class)
            ->getMock();
        $channelContext = $this->getMockBuilder(ChannelContextInterface::class)
            ->getMock();
        $channel = $this->getMockBuilder(Channel::class)
            ->getMock();
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        
        $checkoutStateUrlGenerator
            ->expects($this->once())
            ->method('generateForOrderCheckoutState')
            ->will($this->returnValue($expected))
        ;
        $channel
            ->expects($this->once())
            ->method('getCheckoutFlow')
            ->will($this->returnValue('flow_1'))
        ;
        $order
            ->expects($this->once())
            ->method('getChannel')
            ->will($this->returnValue($channel))
        ;
        $order
            ->expects($this->once())
            ->method('getCheckoutState')
            ->will($this->returnValue('addressed'))
        ;
        
        $groupedConfig = [
            'flow_2' => [
                'addressed' => [
                    'route' => $expected
                ]
            ]
        ];
        
        $object = new GroupCheckoutStateUrlGenerator($checkoutStateUrlGenerator, $channelContext, $groupedConfig);
        $result = $object->generateForOrderCheckoutState($order);
        
        $this->assertEquals($expected, $result);
    }
}
