## How to run

1. Run `composer install`
2. Create environment variables file: `cp .env.example .env`
3. Run `php artisan key:generate`
4. Input your database server credentials in the .env file
5. Run `php artisan migrate`
6. To have sample data, run `php artisan db:seed`
7. Run `npm install`
8. Register in the application by going to `<domain>/register` or by clicking the REGISTER button at the web page
9. Login as a registered user and be redirected to Users Administration webpage.
