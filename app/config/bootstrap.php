<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */


/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array(
    'engine' => 'File',
    'mask' => 0666,
));

Cache::config('cart', array(
	'engine' => 'File',
	'mask' => 0666,
	'group' => array('cart'),
	'path' => CACHE . 'cart' . DS,
	'prefix' => 'bindery_',
	'duration' => '+1 hour',
	'serialize' => TRUE
));

Cache::config('qb', array(
	'engine' => 'File',
	'mask' => 0666,
	'group' => 'qb',
	'path' => CACHE . 'qb' . DS,
	'prefix' => 'dm_',
	'duration' => '+1 week',
	'serialize' => TRUE
));

Cache::config('catalog', array(
	'engine' => 'File',
	'mask' => 0666,
	'group' => 'catalog',
	'path' => CACHE . 'catalog' . DS,
	'prefix' => 'dm_',
	'duration' => '+1 week',
	'serialize' => TRUE
));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models', '/next/path/to/models'),
 *     'Model/Behavior'            => array('/path/to/behaviors', '/next/path/to/behaviors'),
 *     'Model/Datasource'          => array('/path/to/datasources', '/next/path/to/datasources'),
 *     'Model/Datasource/Database' => array('/path/to/databases', '/next/path/to/database'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions', '/next/path/to/sessions'),
 *     'Controller'                => array('/path/to/controllers', '/next/path/to/controllers'),
 *     'Controller/Component'      => array('/path/to/components', '/next/path/to/components'),
 *     'Controller/Component/Auth' => array('/path/to/auths', '/next/path/to/auths'),
 *     'Controller/Component/Acl'  => array('/path/to/acls', '/next/path/to/acls'),
 *     'View'                      => array('/path/to/views', '/next/path/to/views'),
 *     'View/Helper'               => array('/path/to/helpers', '/next/path/to/helpers'),
 *     'Console'                   => array('/path/to/consoles', '/next/path/to/consoles'),
 *     'Console/Command'           => array('/path/to/commands', '/next/path/to/commands'),
 *     'Console/Command/Task'      => array('/path/to/tasks', '/next/path/to/tasks'),
 *     'Lib'                       => array('/path/to/libs', '/next/path/to/libs'),
 *     'Locale'                    => array('/path/to/locales', '/next/path/to/locales'),
 *     'Vendor'                    => array('/path/to/vendors', '/next/path/to/vendors'),
 *     'Plugin'                    => array('/path/to/plugins', '/next/path/to/plugins'),
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
	CakePlugin::load('DebugKit');
	CakePlugin::load('Upload');
	CakePlugin::load('PaypalSource');
	CakePlugin::load('Paypal');
	CakePlugin::load('AddressModule');
    CakePlugin::load('Drawbridge');
/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

CakeLog::config('varlog', array(
	'engine' => 'FileLog',
	'types' => array('varlog'),
	'file' => 'varlog'
));

// I think this one has been left behind (1/29/15)
CakeLog::config('cart', array(
'engine' => 'FileLog',
'types' => array('cart'),
'file' => 'Cart/cart'.date('.Y.m')
));

CakeLog::config('order_email', array(
'engine' => 'FileLog',
'types' => array('order_email'),
'file' => 'Cart/email'.date('.Y.m')
));
CakeLog::config('cart_activity', array(
'engine' => 'FileLog',
'types' => array('cart_activity'),
'file' => 'cart/cart_activity'.date('.Y')
));

CakePlugin::load(array('Markdown' => array('bootstrap' => true)));

Configure::write('usps.RateV4Request.@USERID', '872DREAM7410');
Configure::write('usps.RateV4Request.Revision', NULL);
Configure::write('usps.pass', '992UL84JC016');
Configure::write('usps.test', 'https://stg-secure.shippingapis.com/ShippingApi.dll');
Configure::write('usps.call', 'http://production.shippingapis.com/ShippingAPI.dll');
//Configure::write('usps.call', 'http://production.shippingapis.com/ShippingAPI.dll?API=RateV4&XML=');
Configure::write('usps.RateV4Request.Package.@ID', '1ST');
Configure::write('usps.ZipOrigination', '94552');
Configure::write('usps.ZipNear', '94552');
Configure::write('usps.ZipFar', '03901');
Configure::write('usps.Service', 'PRIORITY');
Configure::write('usps.Container', NULL);
Configure::write('usps.Size', 'REGULAR');

Configure::write('Drawbridge.RegistrationRedirect', array('controller' => 'User', 'action' => 'login'));
Configure::write('Drawbridge.PasswordComplexity', array(
    'alpha' => '*',
    'upper' => '*',
    'digit' => '*',
    'special' => '*',
    'length' => '2,256'
    ));


/*
 * <RateV4Request USERID="XXXXXXXXXXXX" >
<Revision/>
<Package ID="1ST">
<Service>PRIORITY</Service>
<ZipOrigination>44106</ZipOrigination>
<ZipDestination>20770</ZipDestination>
<Pounds>1</Pounds>
<Ounces>8</Ounces>
<Container>NONRECTANGULAR</Container>
<Size>LARGE</Size>
<Width>15</Width>
<Length>30</Length>
<Height>15</Height>
<Girth>55</Girth>
</Package>
</RateV4Request>
 */

/**
 * Establish constants
 * 
 */
define ('NEWLINE', "\n");
define ('TAB', "\t");

/**
 * Cart Model Constants
 */
define ('CART_STATE', 'Cart');
define ('COMPLETE_STATE', 'Complete');
define ('SHIPPING_STATE', 'Shipping');
define ('CHECKOUT_STATE', 'Checkout');
define ('QUOTE_STATE', 'Quote');

App::uses('dmDebug', 'Lib');
App::uses('QBModel', 'Lib/QBUtilities');
