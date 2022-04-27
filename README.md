# Employee Management App

## Intro

Code example creating an application that requires auth and provides employee management based on Company.

## Installation

run the following commands to setup the app.

### system requirements

-   PHP >= 7.4
-   Composer
-   Docker
-   Docker Compose

### Setup

```
composer install
sail up -d
sail yarn install
sail yarn development
sail artisan migrate --seed
sail artisan storage:link
```

## Testing

Run the following command once installed to run the tests.

`sail artisan test -p`
