# Simple Customer relationship api

The API handles a simple customer relationship system

- [Simple Crm](#simple-crm)
    - [Install](#install)

## Install

## Simple Crm

Composer install

``` bash
$ composer install
```

After installing, run `key:generate` Artisan command.

``` bash
php artisan key:generate
```

After generating, run `migrate --seed` Artisan command.

``` bash
php artisan:migrate --seed
```

After migrating, run `passport:install` Artisan command.

``` bash
php artisan:passport:install
```

Run `scribe:generate` Artisan command for detailed documentation.

``` bash
php artisan scribe:generate
```

For Testing, run `./vendor/bin/phpunit`  command.

``` bash
./vendor/bin/phpunit
```

##### Documentation
- Visit the following endpoint for detailed documentation visit:
 <code>
    your_base_url/docs
</code>


