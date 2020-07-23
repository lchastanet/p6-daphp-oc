[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1dfdc84091cf4104af9244bde403cebb)](https://app.codacy.com/manual/Fr0x13/p6-daphp-oc?utm_source=github.com&utm_medium=referral&utm_content=Fr0x13/p6-daphp-oc&utm_campaign=Badge_Grade_Dashboard)

# p6-daphp-oc

This project has been carried out with the aim of passing a diploma on the [OpenClassrooms.com](https://openclassrooms.com/) learning platform.
To install it you need to have [composer](https://getcomposer.org/) installed.

Then run

```shell
composer install
```

Then (if needed) modify the **.env** file to connect to your mysql installation

```shell
DATABASE_URL=mysql://username:password@127.0.0.1:3306/db_name
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
symfony server:start
```

- if you don't have installed the symfony cli tool :

```shell
php -S localhost:8000 -t public
```