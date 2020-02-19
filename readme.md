# Laravel Data Cleanser

Follow these steps to get things working:

- Copy the `.env.example` file to `.env`
- Generate an app key with the command `php artisan key:generate`
- Install dependencies with the command `composer install`
- Run the tests with the command `./vendor/bin/phpunit`

As well as the feature tests, you can also run a data cleanliness report with the following command:

- `php artisan data:cleanliness-report`