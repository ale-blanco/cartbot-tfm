Feature: I can create a user for client's admin app
  As a developer
  I want to make sure that the user client is created
  So that the tests pass

  Scenario: Not exist client
    Given a idclient that not exist
    When executing the createuserclient use case throw an ClientNotExistException

  Scenario: Exist a user with this username
    Given a username that exist
    When executing the createuserclient use case throw an UserNameExistException

  Scenario: The password is encoded
    Given a valid data
    When executing the createuserclient use case
    Then the user is create with the password encoded
