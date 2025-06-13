# Overview
This project is a web application for PuppyPowerAcademy. This webapp ensures that the users have a comfortable experience buying products, ordering and viewing trainings and planning their dogs for the daycare.  

# Installation guide:
- Clone the repo
After that run the following commands:
- `composer install`
- `npm install`
- `npm run build`

### database setup
- create a database and remember its name

### .env setup
- create a copy of .env-example and rename it to .env
- set DB_DATABASE to be the name of the database you just created
- set a correct DB_USERNAME and DB_PASSWORD
- create a new app key using the command: `php artisan key:generate`
- link images via storage using the command: `php artisan storage:link`
- run the command:  `php artisan migrate:fresh --seed` to prepare and fill the database with dummy data

### To run the project locally run the following command:
-`composer run dev`
This command opens a server on default url:port http://127.0.0.1:8000
