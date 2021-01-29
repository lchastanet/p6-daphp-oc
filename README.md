[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1dfdc84091cf4104af9244bde403cebb)](https://app.codacy.com/manual/Fr0x13/p6-daphp-oc?utm_source=github.com&utm_medium=referral&utm_content=Fr0x13/p6-daphp-oc&utm_campaign=Badge_Grade_Dashboard)

# p6-daphp-oc

This project has been carried out with the aim of passing a diploma on the [OpenClassrooms.com](https://openclassrooms.com/) learning platform.
To install it you need to have [composer](https://getcomposer.org/) installed.

Then run

```shell
composer install
```

Then create or modify the **.env** file to connect to your mysql installation and setup the mail server

```shell
APP_ENV=dev
APP_SECRET=37475f44748fe184be7865821e6828d6
DATABASE_URL=mysql://username:password@127.0.0.1:3306/db_name
MAILER_DSN=smtp://user:password@server:port
```

Then run the following command to create database

```shell
php bin/console doctrine:database:create
```

Then load the initial dataset into database

```
php bin/console doctrine:fixtures:load
```

And finally run the dev server to test app

- if you have installed the symfony cli tool :

```shell
symfony serve
```

- if you don't have installed the symfony cli tool :

```shell
php -S localhost:8000 -t public
```

If you need to modify the **js** or **css** files then you need to install dependencies :

```shell
yarn install
```

Then take a look to [symfony encore bundle](https://symfony.com/doc/current/frontend/encore/simple-example.html) on official doc.
