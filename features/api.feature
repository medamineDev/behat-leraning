Feature: Testing Web
  check Web behavior



  Scenario: check Register

    Given I am on "/register"

    When I fill in "name" with "amine_2"
    When I fill in "email" with "amine_2@gmail.com"
    When I fill in "password" with "azerty"
    When I fill in "password-confirm" with "azerty"
    And I press "register"
    Then the url should match "/home"




  Scenario: check Login user

    Given I am on "/login"
    When I fill in "email" with "amine_2@gmail.com"
    When I fill in "password" with "azerty"
    And I press "login"
    Then the url should match "/home"
    Then I am logged In with "amine_2@gmail.com"






  Scenario: logout user

    Given I am logged in
    Given I am on "/home"

    And I press "logout"
    Then the url should match "/"




  Scenario:  reset Data

    Then I remove the  user with mail "amine_2@gmail.com"
























