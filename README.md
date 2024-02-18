# Docker-php-ngnix-mysql
A docker compose php,nginx and mysql template

## Installation
1. Clone the repository
2. Run `docker-compose up -d` to start the containers
3. Once the containers are up and running you need to install the composer dependencies by running `docker-compose exec php_app_name composer install`
4. You can now access the application by visiting `http://localhost:8080` in your web browser
5. To stop the containers run `docker-compose down`


## Framework Directory Information
The Framework folder is where the base classes are located, like the router, base controller and base model.  

The Base Controller contains a view method that is used to render views and pass data to the view.

The Base Model contains methods to interact with the database.  

All controllers and models should extend the base classes, in order to use the methods and properties.

