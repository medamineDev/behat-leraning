Feature: Testing Web
  check Web behavior



  Scenario: Searching for a page that does exist

    Given I am on "/register"
    When I fill in "name" with "amine_2"
    When I fill in "email" with "amine_2@gmail.com"
    When I fill in "password" with "azerty"
    When I fill in "password-confirm" with "azerty"
    And I press "btn btn-primary"
    Then I should see "Principles of BDD"








