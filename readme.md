## About Laravel-Boilerplate
    Laravel-boilerplate is a template for web application development with built in user, roles, permissions management and more.
    This project is work in progress...

## Installation
1. Clone the repository.
    ``` sh
    git clone https://github.com/ferdiebergado/laravel-boilerplate.git
    ```
2. Create a .env file.
    ``` sh
    cp .env.example .env
    ```
    Edit the .env file accordingly.

3. Install dependencies.
    ``` sh
    composer install
    ```
4. Setup the database.
    ``` sh
    php artisan migrate --seed
    ```
5. Run the development server.
    ``` sh
    php artisan serve
    ```
6. Login as admin:
    * email: admin@example.com
    * password: letmein

