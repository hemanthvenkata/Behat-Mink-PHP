# features/search.feature
Feature: Check first checkbox and enter an email
  In order to send mail
  As a website user
  I need to be able to enter the email data and check the checkboxes

  Scenario Outline: Click send after checking the first checkbox and entering the email 
    Given I am on "https://saucelabs.com/test/guinea-pig"
    When I go to "https://saucelabs.com/test/guinea-pig"
    Then I should see "This page is a Selenium sandbox"
    When I click on the first checkbox
    #Then The first checkbox should be checked - Wont work as the its not changing the attribute checked dynamically.
    When I fill in "fbemail" with "<email>"
    And I press "submit"
    Then I should see "This page is a Selenium sandbox"

    Examples:
    | email                  |
    | abcde@sample.com       |
    | defghh@sample.com      |