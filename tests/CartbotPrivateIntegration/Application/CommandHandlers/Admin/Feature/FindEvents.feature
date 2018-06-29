Feature: I can see and filter all events
  As a user of client
  I want to make sure that I can see all events with filters
  So that the tests pass

  Scenario: The type to find is not valid
    Given a not valid type to filter
    When executing the findevents use case throw an ValidateException with key type

  Scenario: The start date is not valid
    Given a not valid start date
    When executing the findevents use case throw an ValidateException with key dateStart

  Scenario: The end date is not valid
    Given a not valid end date
    When executing the findevents use case throw an ValidateException with key dateEnd

  Scenario Outline: The page is not valid
    Given a not valid page whit value <page>
    When executing the findevents use case throw an ValidateException with key page

    Examples:
      | |
      | 0 |
      | a |
      | -1 |

  Scenario: The order is not valid
    Given a not valid order
    When executing the findevents use case throw an ValidateException with key order

  Scenario: All data filters is valid
    Given a valid data filters
    When executing the findevents use case
    Then response a FindEventsOut
