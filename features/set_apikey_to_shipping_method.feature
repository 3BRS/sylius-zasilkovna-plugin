@set_apikey_to_shipping_method
Feature: Set Packeta api key to shipping method
	In order to add a Packeta API key to shipping method settings in admin panel
	As an Administrator
	I want to add Packeta API key to the shipping method

	Background:
		Given the store operates on a single channel in "United States"
		And the store allows shipping with "Packeta" identified by "packeta"
		And I am logged in as an administrator

	@ui
	Scenario: Set Packeta api key to shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta api key to "RANDOM_API_KEY"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta api key for this shipping method should be "RANDOM_API_KEY"

	@ui
	Scenario: Remove Packeta api key from shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta api key to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta api key for this shipping method should be ""

	@ui
	Scenario: Set Packeta Sender label to shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta Sender label to "RANDOM_TEXT_1"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta Sender label for this shipping method should be "RANDOM_TEXT_1"

	@ui
	Scenario: Remove Packeta Sender label from shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta Sender label to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta Sender label for this shipping method should be ""

	@ui
	Scenario: Set Packeta Carrier pickup point to shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta Carrier pickup point to "RANDOM_TEXT_2"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta Carrier pickup point for this shipping method should be "RANDOM_TEXT_2"

	@ui
	Scenario: Remove Packeta Carrier pickup point from shipping method
		Given I want to modify a shipping method "Packeta"
		When I change Packeta Carrier pickup point to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Packeta Carrier pickup point for this shipping method should be ""
