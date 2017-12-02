@checkout_flow_ui_shop_use_checkout_flow_3
Feature: Purchase a product using checkout flow 3 for a channel
    In order to give possibility to buy a product on my stores website
    As a Guest
    I want to be able to complete product purchase making shipping and payment in the same step

    Background:
        Given the store operates on a single channel in "United States"
        And the store has checkout flow "sylius_order_checkout_3"
        And the store has a product "Marabunta" priced at "$5.00"
        And the store ships everywhere for free
        And the store allows paying offline

    @ui
    Scenario: Complete address abd shipping, payment and complete steps to purchase a product
        Given I have product "Marabunta" in the cart
        And I am at the checkout addressing and select shipping step
        When I specify the shipping address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I specified email "john@example.com"
        And I select "Free" shipping method
        And I complete the addressing and select shipping step
        Then I should be on the checkout payment and complete step
        And I select "Offline" payment method
