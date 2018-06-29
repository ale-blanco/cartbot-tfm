Feature: I can change my pass
  As a user of client
  I want to make sure that the password is changed
  So that the tests pass

  Scenario: My actual pass is not valid
    Given a actual password that is not valid
    When executing the changepass use case throw an PasswordNotValidException

  Scenario: New password equal actual password
    Given a new password that is equal the actual
    When executing the changepass use case throw an PasswordEqualActualException

  Scenario: Correct change of pass
    Given a actual and new pass valid
    When executing the changepass use case
    Then response a OK and the user is saved