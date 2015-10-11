# features/search.feature
Feature: Individual Price and Manual Price
  In order to validate plan and price
  As a website user
  I need to be able to see the given plan and price

  Scenario Outline: Searching for a given plan and price
    Given I am on homepage
    Then I should be on homepage
    When I click on the hamburger element with title as "<links>"
    Then I should see "<headers>"
    #need to verify the given Text
    Then I should see text matching "<plans>"
    Then I should see "<price>"

    Examples:
    | links   | headers                               | plans       | price |
    | Pricing | Sauce Labs Subscription Plan Pricing  | Individual  | $49   |
    | Pricing | Sauce Labs Subscription Plan Pricing  | Manual      | $12   |