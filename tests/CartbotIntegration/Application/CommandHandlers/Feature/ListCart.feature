Feature: I can list my cart
  As a user chat
  I want to make sure that the cart is listed
  So that the tests pass

  Scenario: Receive a order list cart
    Given a listcart command
    When executing the listcart use case
    Then send a event listcart