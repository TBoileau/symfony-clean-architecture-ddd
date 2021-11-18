Feature: As a user I want to request a forgotten password In order to reset my password
  Scenario: Should create a forgotten password token for the next 24 hours
    Given I registered with my email address user+1@email.com
    When I request a forgotten password with user+1@email.com
    Then I can use my forgotten password token for the next 24 hours
  Scenario: Should not create a forgotten password token because of a non-existing email
    Given I registered with my email address user+1@email.com
    When I request a forgotten password with user+0@email.com
    Then I get an error that tells me "This email does not exist."
  Scenario: Should not create a forgotten password token because a request was already made less than 24 hours ago
    Given I registered with my email address user+1@email.com
    And I have already request a forgotten password 12 hours ago
    When I request a forgotten password with user+1@email.com
    Then I get an error that tells me "You have already request for a forgotten password last 24 hours."
