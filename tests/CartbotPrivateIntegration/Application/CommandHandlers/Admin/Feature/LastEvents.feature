Feature: I can see today's events by type and by hour
  As a user of client
  I want to make sure that I can see this data
  So that the tests pass

  Scenario: Get today's events by type and by hour
    Given a number of client for lastevents
    When executing the lastevents use case
    Then response a lastseventsout with data