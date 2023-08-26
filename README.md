Main Technologies used:
- PHP 8.2.6
- Laravel 10.15.0
- MySQL 8.0.3
  

Instructions:

- php artisan migrate
- php artisan db:seed

Note: If `php artisan db:seed` doesn't work then run manually the following seeders.

- php artisan db:seed --class=UsersTableSeeder
- php artisan db:seed --class=SitesTableSeeder
- php artisan db:seed --class=BillsTableSeeder



User Stories (Given/When/Then):


A: Design a system that stores data from electricity bills received every month. Bills will contain a customer account number, an invoice number, a site identifier, the bill start and end dates, and the corresponding total amount ($) and total electricity usage (kWh). The site identifier is alphanumeric and 10 characters long.

	User Story:
		Given that I am setting up a system,
		When I create a bills table in the database,
		Then it should have the following fields: customer account number, invoice number, site identifier, bill start date, bill end date, total amount, and total electricity usage.


	Acceptance Criteria:
		Given a bills table in the database,
		When I inspect the table structure,
		Then it should have the following fields:
			- id: bigint unsigned not null auto increment primary key
			- customer_account_number: varchar(10) not null
			- invoice_number: varchar(10) not null
			- site_identifier: varchar(10) not null
			- bill_start_date: date not null
			- bill_end_date: date not null
			- total_amount: decimal(8, 2) not null
			- total_electricity_usage: int not null
			- created_at: timestamp
			- updated_at: timestamp


B: Multiple bills need to be linked to a site based on a matching site identifier. A site contains a name and address. Additionally, a user is appointed as the site’s manager. The user has a name and can manage more than one site at any given time.

	User Story:
		Given that I am setting up a system,
		When I create a users table in the database,
		Then it should have the necessary fields: id, name, created_at and updated_at.

		Given that I am setting up a system,
		When I create a sites table in the database,
		Then it should have the following fields: id, name, address, site_manager_id, created_at and updated_at. And site_manager_id references the id of the users table.

		Given that I have created the necessary tables for the bills, sites and users,
		When I establish a one-to-many relationship between the Sites and Bill tables,
		Then a site should be able to have multiple bills associated with a site.

		Given that I have created the necessary tables for the bills, sites and users,
		When I establish a one-to-many relationship between the Users and Sites tables,
		Then a site should be able to have multiple sites associated with a user.

	Acceptance Criteria:
		Given a sites table in the database,
		When I inspect the table structure,
		Then it should have the following fields:
			- id: varchar(10) not null primary key
			- name: varchar(60) not null
			- address: varchar(80) not null
			- site_manager_id: bigint unsigned not null
			- created_at: timestamp
			- updated_at: timestamp

		Given a users table in the database,
		When I inspect the table structure,
		Then it should have the following fields:
			- id: bigint unsigned not null auto increment primary key
			- name: varchar(255) not null
			- created_at: timestamp
			- updated_at: timestamp

		Given the necessary tables for sites and users in the database,
		When I establish a one-to-many relationship between the Bill and Site tables,
		Then a site should be able to have multiple bills associated with a site.

		Given the necessary tables for sites and users in the database,
		When I establish a one-to-many relationship between the Users and Sites tables,
		Then a site should be able to have multiple sites associated with a user.


C: The system needs to display a field to select a month. Upon selection,display a list of bill invoice numbers which end in that month.

	User Story:
		Given that I am using the system,
		When I navigate to the bills page,
		Then I should see a field to select a month.

		Given that I have selected a specific month in the month selection field,
		When I submit the form or make the selection,
		Then the system should display a list of bill invoice numbers that end in the selected month.

	Acceptance Criteria:
		Given I am on the bills page,
		When I view the page,
		Then I should see a dropdown or input field to select a month.

		Given I have selected a specific month in the month selection field,
		When I submit the form or make the selection,
		Then the system should retrieve and display a list of bill invoice numbers that have an end date in the selected month.

		Given I have submitted the form
		When the system has no data for that specific date
		Then it should return No records found.


D: The system needs to display details for any given site. The site details should include the name, address, and an average yearly total amount ($) calculated using the bill data for the site.
	
	User Story:
		Given that I am using the system,
		When I navigate to the site details page,
		Then I should see the details for a specific site, including the name, address, and average yearly total amount.

		Given that I am viewing the site details page,
		When I examine the site details section,
		Then I should see the name and address of the site displayed.

		Given that the site has bill data associated with it,
		When the system calculates the average yearly total amount for the site,
		Then the calculated amount should be displayed in the site details section.

	Acceptance Criteria:
		Given I am on the site details page,
		When I view the page,
		Then I should see the name and address of the site displayed in the site details section.

		Given the site has bill data associated with it,
		When the system calculates the average yearly total amount for the site,
		Then the calculated amount should be displayed in the site details section.


E: The system needs to display a list of sites that are managed by any given user. Each site should display the total amount ($) and total electricity usage (kWh) from its latest available bill.


	User Story: 
		Given that I am using the system,
		When I navigate to the sites list page,
		Then I should see a list of sites managed by the selected user / site manager.

		Given that I am viewing the list of sites,
		When I examine the details for each site,
		Then I should see the total amount and total electricity usage from the latest available bill for each site.

	Acceptance Criteria:
		Given I am viewing the list of sites managed by a user,
		When I examine the details for each site,
		Then I should see the total amount and total electricity usage from the latest available bill for each site.

		Given a site has multiple bills associated with it,
		When the system retrieves the latest available bill for the site,
		Then the total amount and total electricity usage from that bill should be displayed for the site.


F: The system should include a graph for a given site that displays the total amount ($) of each bill for the site in an appropriate format.

	User Story:
		Given that I am using the system,
		When I navigate to the site details page,
		Then I should see a bar graph displaying the total amount of each bill for the selected site.

	Acceptance Criteria:
		Given I am on the site details page,
		When I select a site from the list of sites,
		Then I should see a bar graph displaying the total amount of each bill for the selected site.
