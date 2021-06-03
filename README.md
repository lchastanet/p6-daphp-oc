[![Codacy Badge](https://app.codacy.com/project/badge/Grade/86ec6bb486a04467ad13ae1c40cae420)](https://www.codacy.com/gh/lchastanet/p6-daphp-oc/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=lchastanet/p6-daphp-oc&amp;utm_campaign=Badge_Grade)

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
