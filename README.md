# Customer Portal

## Technologies Used

- PHP 5
- Apache
- Symfony2 (version 2.8)
- Twig
- Doctrine
- MySQL
- Bootstrap
- PHP Unit

## The Brief - Specification Overview

- Customer can log in with valid credentials
- It displays a list of basic customer info
- Customer info can be updated
- New passengers can be added
- Passengers can be deleted
- New trips can be added
- Trips can be deleted

## Challenges

- Getting Apache to load the correct PHP configuration file (php.ini) as Homebrew build had no file loaded
  - I tried changing configuration files for both Apache and PHP - discovered apache was not finding the correct PHP directory
- PHP is a very new language for me
  - I have mostly used Ruby and JavaScript and only briefly used PHP to tackle the 'Fizzbuzz' challenge
  - Although Ruby is also an object-oriented language, PHP has some quirks and the syntax is fairly new for me.
- Using largely unfamiliar technologies
  - The only other technology I have used in previous projects is Bootstrap. There was a lot to learn of Symfony, Twig and Doctrine, although I found the Symfony2 docs extremely detailed and clear.
- Installing and enabling extensions e.g. ‘intl’ using composer
  - Tried installing both natively and by using PEAR and PECL, however after much configuration, neither proved successful. In the interest of saving time, I decided to eventually skip fixing the installation and focus on other tasks.
- Repopulating a MySQL database deployed on Heroku
  - Heroku by default uses PostgreSQL. I used Heroku's ClearDB add-on to deploy the MySQL database, but ClearDB does not have an option to fork a copy of a local database to the deployed version. As a work-around, I created a '/create' controller route near the beginning of building to create new users to interact with, as they could not be entered manually with MySQL on the production server.

## Instructions

### To try out the app online

- Visit https://br-customer-portal.herokuapp.com/
- On the login page, enter `Ontro Ltd.` into the `Name` field.
- Enter any password (currently there is no user authentication/validation) and click `Login`
- To edit the customer information, edit the fields (except for `Name`) and click `Update`
- You can add and delete passengers

### To run locally

- Fork the repository and clone into it - `$ git clone git@github.com:BenRoss92/customer_portal.git && cd customer_portal`
- Install the dependencies
  - `$ composer install`
  - Update external dependencies using `$ composer update`
- Make sure all of the required technologies are installed - PHP, Apache, Symfony, MySQL, Composer, Bower and PHPUnit
- Run the tests - `$ phpunit -c app --debug`
- Run the server - `$ php app/console server:run`
- Visit the URL address displayed in the command line (the default is http://localhost:8000)
