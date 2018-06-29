Feature: I can receive a message when service not understood my text
  As a user chat
  I want to make sure that the NotUnderstood works
  So that the tests pass

  Scenario: Receive a text not valid
    Given a command notunderstood
    When executing the notunderstood use case
    Then send a event notunderstood