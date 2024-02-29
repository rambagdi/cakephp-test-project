<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->setExtensions(['json', 'xml']);
    
	
    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        //$builder->connect('/add', ['controller' => 'Users', 'action' => 'add']);
        //$builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        $builder->resources('Articles');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /*$routes->scope('/api', function (RouteBuilder $builder): void {
        // No $builder->applyMiddleware() here.
   	
         // Parse specified extensions from URLs
         
         $builder->setExtensions(['json', 'xml']);
    	 $builder->connect('/articles', ['controller' => 'Articles', 'action' => 'index']);
    	 $builder->fallbacks();
       // Connect API actions here.
     }); */
     	// API routes
	Router::prefix('Api', function (RouteBuilder $routes) {
		$routes->setExtensions(['json']);
		
		//User api start
		$routes->post('/login', ['controller' => 'ApiUsers', 'action' => 'login']);
		$routes->post('/users', ['controller' => 'ApiUsers', 'action' => 'add']);
		$routes->get('/users', ['controller' => 'ApiUsers', 'action' => 'index']);
		$routes->get('/logout', ['controller' => 'ApiUsers', 'action' => 'logout']);
		$routes->put('/users/{id}', ['controller' => 'ApiUsers', 'action' => 'edit'])->setPass(['id']);
		$routes->delete('/users/{id}', ['controller' => 'ApiUsers', 'action' => 'delete'])->setPass(['id']);
		//User api end
		
		// Articles api start
		$routes->post('/articles', ['controller' => 'Articles', 'action' => 'add']);
		$routes->get('/articles', ['controller' => 'Articles', 'action' => 'index']);
		$routes->put('/articles/{id}', ['controller' => 'Articles', 'action' => 'edit'])->setPass(['id']);
		$routes->delete('/articles/{id}', ['controller' => 'Articles', 'action' => 'delete'])->setPass(['id']);
		//Articles api end
		
		// Like api start
		$routes->post('/likes', ['controller' => 'Likes', 'action' => 'add']);
		$routes->get('/likes', ['controller' => 'Likes', 'action' => 'index']);
		//Like api end
		
		$routes->fallbacks();
	});
    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
    /* $routes->scope('/api', function (RouteBuilder $builder): void {
     	//$builder->setExtensions(['json']);
     	
     	$builder->post('/prices/login', ['controller' => 'PriceUsers', 'action' => 'login', 'prefix' => 'Api']);
     	
     	$builder->get('/prices', ['controller' => 'PriceUsers', 'action' => 'index', 'prefix' => 'Api']);
     
     });*/
};
