Feature: Testing API
  check api calls


  Scenario: Home Page

    Given I am on the homepage
    Then  I should see "laravel"


  Scenario: is URL correct
    When I go to "home"
    Then  the url should match "/"



  Scenario: get array list

    When I make request "GET" "/api/get_list/"
    Then the response should be JSON
    Then the response status code should be 200




  Scenario: post array list

    When I make request "POST" "/api/get_list" with following JSON content:
    """
    {
    "user": "user-id",
    "title": "Some title",
    "number": 12
    }
    """

    Then print last response
    Then the response should be JSON
    Then the response should contain "success"





  Scenario: create user Object

    When I create "user" object  with following JSON content:

    """
    {
    "user": "id",
    "title": "Some title",
    "number": 12
    }
    """

    Then The Object must contain "12"






