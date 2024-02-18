<?php
use Framework\Router;

use App\Controllers\Home\HomeController;
use App\Controllers\Errors\ErrorController;


/**
 *
 * @var Router $router
 *
 * @return void
 */

/**
 *
 * GET Routes
 *
 */

$router->get('/', 'Home\HomeController@index');
$router->get('/404', 'Errors\ErrorController@notFound');


/**
 *
 * POST Routes
 *
 */


/**
 *
 * PUT Routes
 *
 */


/**
 *
 * DELETE Routes
 */

