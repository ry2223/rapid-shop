Installation
------------

```
$ composer install
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
$ php bin/console symfony serve -d --no-tls
$ php bin/console doctrine:fixtures:load
```

```
Set your Stripe secret key in the .env file (STRIPE_SK)
```
