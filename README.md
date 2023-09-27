# SnowTricks
Projet 6 of the **PHP/Symfony** course by OpenClassrooms: Develop the SnowTricks community website from A to Z!

This project was developed using **PHP 8.1.0** and **Symfony 6.3.3**
## Local Installation
To set up the project on your machine, follow these steps:
- Set up a PHP & MySQL environment *(for example, using [MAMP](https://www.mamp.info/en/downloads/))*
- Install  [Composer](https://getcomposer.org/download/)
### 1) Clone the Project and Install Dependencies:
> git clone https://github.com/lau-last/SnowTricks.git

> composer install
### 2) Configure Environment Variables in the **.env**
Modify the database access path:
>DATABASE_URL="mysql://**db_user**:**db_password**@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"

Also, update the Mailer DSN, for example, for [Mailtrap](https://mailtrap.io/) :
>MAILER_DSN=smtp://**User**:**Password**@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login
### 3) Database and Demo Data
Create the database, run the migration, and load demo data:
>php bin/console doctrine:database:create

>php bin/console doctrine:migrations:migrate

>php bin/console doctrine:fixtures:load

## Everything Is Ready!
You can now start the server:
>symfony server:start

The test user account is:
>User : laurent 

> Password : 123