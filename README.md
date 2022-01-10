    ## Clafiya Recruitment Task

## Overview

***The task is to create a Laravel App - Laravel Passport Authentication api that validates a user's email address or phone number and password and returns the users data and passport tokens.***

Laravel Passport provides a full OAuth2 server implementation for Laravel applications and is built on top of the [League OAuth2 server](https://github.com/thephpleague/oauth2-server) that is maintained by Andy Millington and Simon Hamp.r.

### Implementation

As instructed, the API was written in Laravel (a PHP Framework), deployed on AWS EC2 instance, powered by Nginx HTTP server, and the database runs on Mysql database engine powered by AWS Relational Database System (RDS).

### Authentication

> Authentication is the process of verifying the identity of a person or device. A common example is entering a `username` and `password` when you log in to a website. Entering the correct login information lets the website **know who you are** and **that it is actually you** accessing the website.

This API uses OAuth2 Password Grant Type to authenticate users (Powered by Laravel Passport). It typically generates an access token using a given username and password.

## Project Setup(Web Portal)

### Cloning the GitHub Repository.
Clone the repository to your local machine by running the terminal command below.

```bash
git clone repo-url
```
### Setup Database
Create your a MySQL database and note down the required connection parameters. (DB Host, Username, Password, Name) 

### Install Composer Dependencies
Navigate to the project root directory via terminal and run the following command.
```bash
composer install
```
### Create a copy of your .env file
Run the following command 
```bash
cp .env.example .env
```
This should create an exact copy of the .env.example file. Name the newly created file .env and update it with your local environment variables (database connection info and others).

### Generate an app encryption key
```bash
php artisan key:generate
```

### Migrate the database
```bash
php artisan migrate
```
### Publish passport keys
```bash
php artisan passport:keys
```
