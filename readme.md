# Installation

 - set your `APP_URL` and DB configuraton in `.env` file
 - Type this in terminal for DB Migrating and Seeding:

	   php artisan migrate
	   php artisan db:seed

 - give read and write permession to the your web server for storage, cache directories: 

	   sudo chgrp -R www-data storage bootstrap/cache
	   sudo chmod -R ug+rwx storage bootstrap/cache

 - login to admin account via: `APP_URL/login` with the following info:

	   email: admin@admin.com
	   password: 12345678 

	    