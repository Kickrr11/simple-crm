# Simple Customer relationship api

The API handles a simple customer relationship system

- [Simple Crm](#simple-crm)
    - [Install](#install)
    - [API EndPoints](#api-endpoints)
        - [Login](#Login)
        - [Accounts](#Accounts)
        - [Contacts](#Contacts)
        - [Notes](#Notes)

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

For Testing, run `./vendor/bin/phpunit`  command.

``` bash
./vendor/bin/phpunit
```

### API EndPoints
##### Login
* Post `/api/v1/login`
  - use the login details in `database\seeders\UserSeeder.php`
  - Example response:  
    <code>
    {
    
        "success": true,
        "code": 200,
        "locale": "en",
        "message": "OK",
        "data": {
        "access_token": "the access token",
        "token_type": "Bearer",
        "expires_at": "2022-11-17 14:20:46"
        }
    }
    </code>
  - The value of access_token must be included when making requests to each of the endpoints below example:
    
    `
    Content-type: multipart/form-data
    Accept: application/json
    Authorization: Bearer TOKEN
    `

##### Accounts
* GET All `api/v1/accounts`
* GET Single `api/v1/accounts/{account_id}`  
* POST Create `api/v1/accounts`
* PUT Update `api/v1/accounts/{account_id}`
* DELETE Delete `api/v1/accounts/{account_id}`

##### Contacts
* GET All `api/v1/contacts`
* GET Single `api/v1/contacts/{contact_id}`
* POST Create `api/v1/contacts`
* PUT Update `api/v1/contacts/{account_id}`
* DELETE Delete `api/v1/contacts/{account_id}`

##### Notes
* GET All `api/v1/notes`
* GET Single `api/v1/notes/{contact_id}`
* POST Create `api/v1/notes`
* PUT Update `api/v1/notes/{account_id}`
* DELETE Delete `api/v1/notes/{account_id}`
