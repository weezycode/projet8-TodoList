
<h1 align="center">
TodoList
</h1>

## *A startup whose core business is an application to manage daily tasks*.

*The company has just been created, and the application had to be developed at full speed to show potential investors that the concept is viable (we are talking about Minimum Viable Product or MVP).*
*My role here is therefore to improve the quality of the application. Quality is a concept that encompasses many subjects: we often speak of code quality, but there is also the quality perceived by the user of the application or the quality perceived by the company's employees.*

## *Description of the need*
   ### *Corrections d'anomalies*

* *Only referenced clients can access the APIs. API clients must be authenticated via JWT*

## Installation

*Before installing the project make sure you have PHP8 ^ and composer.*

*To install the project, open your terminal, copy the link and paste it in your development path or anywhere*

      git clone https://github.com/weezycode/bilemo.git

*After cloning the project, go to the folder*

      cd bilemo

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
      
## *Documentation*

 *documentation =>  https://localhost:8000/api/docs*   


*If you want a token login with :* 

*Email*

    mauritel@shop.fr
*Password* 

    pass_1234
    
*Enjoy* 😃

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/bba402e9b31e41558192a8af4b8c0e3b)](https://www.codacy.com/gh/weezycode/bilemo/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=weezycode/bilemo&amp;utm_campaign=Badge_Grade)

