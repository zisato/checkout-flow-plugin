@checkout_flow_ui_admin_selecting_checkout_flow
Feature: Selecting available checkout flow for a channel
    In order to give possibility to choose different checkout flow on my stores website
    As an Administrator
    I want to be able to select available checkout flow

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Adding a new channel with checkout flow
        Given I want to create a new channel
        When I specify its code as "WEB-CHECKOUT-FLOW"
        And I name it "Web Checkout Flow"
        And I choose "Euro" as the base currency
        And I choose "English (United States)" as a default locale
        When I choose "sylius_order_checkout_1" as checkout flow
        And I add it
        Then I should be notified that it has been successfully created
        And the checkout flow for the "Web Checkout Flow" channel should be "sylius_order_checkout_1"

    @ui
    Scenario: Selecting checkout flow for existing channel
        Given I want to modify a channel "Web Channel"
        When I select the "sylius_order_checkout_2" as checkout flow
        And I save my changes
        Then I should be notified that it has been successfully edited
        And the checkout flow for the "Web Channel" channel should be "sylius_order_checkout_2"
