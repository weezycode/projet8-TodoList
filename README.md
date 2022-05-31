
<h1 align="center">
TodoList
</h1>

## *A startup whose core business is an application to manage daily tasks*.

*The company has just been created, and the application had to be developed at full speed to show potential investors that the concept is viable (we are talking about Minimum Viable Product or MVP).*
*My role here is therefore to improve the quality of the application. Quality is a concept that encompasses many subjects: we often speak of code quality, but there is also the quality perceived by the user of the application or the quality perceived by the company's employees.*

## *Description of the need*

### *1. Bug fixes*

* *A task must be attached to a user*
* *Choose a role for a user*

### *2. Implementation of new features*

* *Autorisation*
* *Implementation of automated tests*
* *Technical documentation*
* *Code quality audit & application performance*

## Installation

*Before installing the project make sure you have PHP8 ^ and composer.*

*To install the project, open your terminal, copy the link and paste it in your development path or anywhere*

      git clone https://github.com/weezycode/projet8-TodoList.git

*After cloning the project, go to the folder*

      cd projet8-Todolist

*Now install the project*

      composer install
## *Create the database mysql or other and update the .ENV file for the database connection * 


### :warning:  *if you don't have the Symfony CLIENT use  "php bin/console" instead "symfony console"*


*Make migrate the tables in your database*

      symfony console doctrine:migrations:migrate
*Now launch the datasets*

      symfony console doctrine:fixtures:load  
*Now launch a server* 

      symfony serve       
*Or*

      php bin/console server:run
      
 ## *Test a project*
 
        php bin/phpunit
 *Code Coverage*
 
         php bin/phpunit --coverage-html public/test-coverage 
      
## *Go to app*

 *[login](https://localhost:8000)*   


*login Admin:* 

*username*

    Alpha
*Password* 

    pass_1234
    
*Enjoy* 😃

