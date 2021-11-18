Feature: As a user I want to reset my password In order to be able to log in again
  Scenario: Should reset the password and delete the forgotten password request
    Given I registered with my email address user+1@email.com
    And I requested a forgotten password 12 hours ago
    When I reset my password with new_password
    Then My password is reset and I can log in again
  Scenario: Should not reset the password with a token older than 24 hours
    Given I registered with my email address user+1@email.com
    And I requested a forgotten password 36 hours ago
    When I reset my password with new_password
    Then I get an error that tells me "You need to make a forgotten password request."