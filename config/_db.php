<?php

/**
 * Database configuration
 *
 * @return array
 *
 * Information for setting up the database connection:
 * - Host should be the same as the service name in the docker-compose.yml file for the database
 * - Port should be the same as the port in the docker-compose.yml file for the database external port(right side of the colon)
 * - Dbname should be the same as the database name in the docker-compose.yml file for the database
 * - Username should be the same as the username in the docker-compose.yml file for the database
 * - Password should be the same as the password in the docker-compose.yml file for the database
 */

return [
    'host' => 'db_app_name',
    'port' => 3306,
    'dbname' => 'app_db',
    'username' => 'app_user',
    'password' => 'secret'
];
