Feature: I can view number of events in last 7 days
  As a user of client
  I want to make sure that I get the events of last 7 days
  So that the tests pass

  Scenario: Get the number of events in las 7 days
    Given a number of client
    When executing the lastsevendaysevents use case
    Then response a lastaddedout with data