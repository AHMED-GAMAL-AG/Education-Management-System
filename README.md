## Installation 

Clone the repository

    git clone https://github.com/AHMED-GAMAL-AG/Education-Management-System.git

Switch to the root folder

    cd Education-Management-System

Install all the dependencies using composer 

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Create Admin user, permissions, and Admin Role

    php artisan shield:install 

Seed the Database

    php artisan db:seed 
