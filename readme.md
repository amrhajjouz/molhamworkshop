# Installation

- Set your DB configuraton in your `.env` file
- Type this in terminal for DB Migrating and Seeding:

        php artisan migrate
        php artisan db:seed

- For non Windows users, give read and write permession to the your web server for storage, cache directories: 

        sudo chgrp -R www-data storage bootstrap/cache
        sudo chmod -R ug+rwx storage bootstrap/cache

- Login to admin account via: `APP_URL/login` with the following info:

        email: admin@admin.com
        password: 12345678    


# SPA Files

    ├── public
    │   ├── ng
    │   │   ├── controllers             #AngularJS SPA controllers (only .js files)
    │   │   └── templates               #AngularJS SPA templates (only .htm files)


# SPA Routes

Configuration for SPA routes in the file: `routes/ng.php`

this file returns an array which represents all routes.

The route structure as the following:

    {routeName} => [{Url}, {controllerPath}, {templatePath}]

- `controllerPath`: must be written without .js extension
- `templatePath`: must be written without .htm extension and separated with (.), not slashes

