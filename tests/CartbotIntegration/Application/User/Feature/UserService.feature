Feature: I can obtain the user of an id chat
  As a user of chat
  I want to make sure that the user is registered in app
  So that the tests pass

  Scenario: The user is not registered
    Given a id chat that is not registered
    When executing the userservice throw an UserChatNotRegisteredException

  Scenario: The customerToken is valid
    Given a id chat valid and token is valid
    When executing the userservice
    Then response an UserChat and the token is not refreshed

  Scenario: The customerToken is not valid
    Given a id chat valid and token is not valid
    When executing the userservice
    Then response an UserChat and the token is refreshed and saved