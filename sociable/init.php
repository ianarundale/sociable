<?php defined('SYSPATH') or die('No direct script access.');

/******************************
 * Default routing
 *****************************/

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
                        'controller' => 'welcome',
                        'action' => 'index',
                   ));

/******************************
 * Default Api routing
 *****************************/
Route::set('api', 'api')
        ->defaults(array(
                        'directory' => 'api',
                        'controller' => 'index',
                        'action' => 'index',
                   ));