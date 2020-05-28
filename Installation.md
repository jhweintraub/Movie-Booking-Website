Project Code Written by
Josh Weintraub
Vanessa Stewart

Team 12

How to properly add this repo

Things you need to install before this works
    a. PHP
    b. composer
    c. laravel - make sure the DB and all other drivers is installed if you're on windows.
    
1. Install mysql and create new database called ```4050_project```
    a. go to .env and add the sql connection info to the section for "DB". It should look like this
    ```DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=4050_project
    DB_USERNAME=root
    DB_PASSWORD=[insert password]```

    b. add smtp info to .env file for email verification
   
2. go to the terminal and navigate to 
cs4050_term_project/cs4050_term_project. Whatever the directory that this file is in.

3. run ```composer update``` to install the dependencies. 
4. run `php artisan migrate` to create the database scheme and then check your mysql instance to verify

5. run `php artisan serve` and a message should pop up that says `Laravel development server started`
 and a localhost address. Visit the address and verify that the server has booted correctly            

