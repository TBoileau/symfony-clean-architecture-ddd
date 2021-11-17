Feature: As a user I want to reset my password In order to be able to log in again
  Scenario: Should reset the password and delete the forgotten password request
    Given I registered with my email address user+1@email.com
    And I request a forgotten password
    When I reset my password with new_password
    Then My password is reset and I can log in again