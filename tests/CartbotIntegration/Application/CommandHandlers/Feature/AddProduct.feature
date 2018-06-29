Feature: I can add product to my cart
  As a user chat
  I want to make sure that the product is added
  So that the tests pass

  Scenario: Not finded products
    Given a product that not exist
    When executing the addproduct use case throw an NotFindedProductException

  Scenario: Finded products
    Given a product that exist
    When executing the addproduct use case
    Then send a event addproduct