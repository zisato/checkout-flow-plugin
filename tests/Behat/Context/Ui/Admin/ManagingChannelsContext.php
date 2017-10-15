<?php

namespace Tests\Jrc\CheckoutFlowPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Sylius\Component\Core\Model\ChannelInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin\CreatePageInterface;
use Tests\Jrc\CheckoutFlowPlugin\Behat\Page\Admin\UpdatePageInterface;
use Webmozart\Assert\Assert;

/**
 * @author javierrodriguez
 */
final class ManagingChannelsContext implements Context
{    
    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @var Fixture
     */
    private $channelFixtures;

    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @param EntityManager $em
     * @param Fixture $channelFixtures
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     */
    public function __construct(
        EntityManager $em,
        Fixture $channelFixtures, 
        CreatePageInterface $createPage, 
        UpdatePageInterface $updatePage
    ) {
        $this->em = $em;
        $this->channelFixtures = $channelFixtures;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }
    
    /**
     * @BeforeScenario @checkout_flow_ui_admin_selecting_checkout_flow
     */
    public function loadFixtures()
    {
        $this->channelFixtures->load($this->em);
    }
	
    /**
     * @Given I want to create a new channel
     */
    public function iWantToCreateANewChannel()
    {
        $this->createPage->open();
    }

    /**
     * @When I specify its code as :code
     */
    public function iSpecifyItsCodeAs($code = null)
    {
        $this->createPage->specifyCode($code);
    }

    /**
     * @When I name it :name
     */
    public function iNameIt($name = null)
    {
        $this->createPage->nameIt($name);
    }

    /**
     * @When I choose :currency as the base currency
     */
    public function iChooseAsABaseCurrency($currency = null)
    {
        $this->createPage->chooseBaseCurrency($currency);
    }

    /**
     * @When I choose :locale as a default locale
     */
    public function iChooseAsADefaultLocale($locale = null)
    {
        $this->createPage->chooseDefaultLocale($locale);
    }

    /**
     * @When I choose :checkoutFlow as checkout flow
     */
    public function iChooseAsCheckoutFlow($checkoutFlow)
    {
        $this->createPage->chooseCheckoutFlow($checkoutFlow);
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Then the checkout flow for the :channel channel should be :checkoutFlow
     */
    public function theCheckoutFlowForTheChannelShouldBe($channel, $checkoutFlow)
    {
        $this->updatePage->open(['id' => $channel->getId()]);

        Assert::true($this->updatePage->isCheckoutFlowChosen($checkoutFlow));
    }

    /**
     * @Given I want to modify a channel :channel
     * @Given /^I want to modify (this channel)$/
     */
    public function iWantToModifyChannel(ChannelInterface $channel)
    {
        $this->updatePage->open(['id' => $channel->getId()]);
    }

    /**
     * @When I select the :checkoutFlow as checkout flow
     */
    public function iSelectTheAsCheckoutFlow($checkoutFlow)
    {
        $this->updatePage->chooseCheckoutFlow($checkoutFlow);
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }
}
