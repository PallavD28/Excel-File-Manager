
# Laravel Project Setup

## Introduction
This guide will walk you through the steps to set up and run this project.

### Prerequisites
* PHP installed on your local machine.
* Composer installed.
* PostgreSQL database server.
* Git installed.

## Installation Steps
### 1. Clone Repository
* First, clone the repository from GitHub to your local machine
   ``` 
   git clone <repository-url>
   cd <repository-name>
   ```
###   2. Copy .env.example to .env
* Copy the example environment configuration file to a new .env file.
```
    cp .env.example .env
```
### 3. Update .env File
* Open the .env file and update the database configuration to match your PostgreSQL setup.
```
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
```
### 4. Enable PHP Extensions
* Ensure the following extensions are enabled in your php.ini file. Uncomment (remove the ; at the beginning) if necessary.
```
    extension=curl
    extension=fileinfo
    extension=gd
    extension=mbstring
    extension=openssl
    extension=pdo_pgsql
    extension=pgsql
```
The php.ini file is located in your PHP installation directory.

### 5. Install Composer Dependencies
* Install the project dependencies using Composer.
```
    composer install
```
### 6. Generate Application Key
* Generate the application key, which is used for encryption.
```
    php artisan key:generate
```
### 7. Generate JWT Secret
* Generate the JWT (JSON Web Token) secret key.
```
    php artisan jwt:secret
```
### 8. Run Database Migrations
* Run the database migrations to create the necessary tables.
```
    php artisan migrate
```
### 9. Seed the Database
* (Optional) Seed the database with initial data.
```
    php artisan db:seed
```
### 10. Serve the Application
* Run the application using the built-in PHP server
```
    php artisan serve
```