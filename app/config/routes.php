<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/home', array('controller' => 'pages', 'action' => 'display', 'home')); //doesn' highlight menu
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display', 'base' => 'pages'));

    $staticPages = array(
        'contact',
        'intern',
        'policies'
    );

$staticList = implode('|', $staticPages);

Router::connect('/:static', array(
        'plugin' => false,
        'controller' => 'pages',
        'action' => 'display'), array(
                'static' => $staticList,
                'pass' => array('static')
                )
        );


//        Router::connect('/products/ingest_images',
//                array('controller' => 'products', 'action' => 'ingestImages'));
//        Router::connect('/products/:pname/gallery/:id/:page',
//                array('controller' => 'products', 'action' => 'gallery', 'page' => null),
//                array('pname' => '[A-Za-z]+'));
//
//        Router::connect('/products/:pname/gallery/*',
//                array('controller' => 'products', 'action' => 'gallery'),
//                array('pname' => '[A-Za-z]+'));
//
//        Router::connect('/products/:pname/*',
//                array('controller' => 'products', 'action' => 'view', 'pname' => null),
//                array('pname' => '[A-Za-z]+'));
//
//        Router::connect('/art/*',
//                array('controller' => 'products', 'action' => 'art'));
//        Router::connect('/traveler',
//                array('controller' => 'products', 'action' => 'view', 'pass' => array('traveler')));
//        Router::connect('/kandinsky',
//                array('controller' => 'products', 'action' => 'art', 'pass' => array('kate_jordahl','kandinsky')));


        Router::connect('/products',
                array ('controller'=>'contents','action'=>'gallery','pname'=>null));
        
        Router::connect('/products/:pname/gallery/*',
                array ('controller'=>'contents','action'=>'gallery','pname'=>null));
        
        Router::connect('/products/:pname/news/*',
        array ('controller'=>'contents','action'=>'newsfeed','pname'=>null));
                
        Router::connect('/products/:pname/*',
                array ('controller'=>'contents','action'=>'gallery','pname'=>null));
        
        Router::connect('/art/*',
                array ('controller'=>'contents','action'=>'art'));
        Router::connect('/workshops',
                array ('controller'=>'workshops','action'=>'upcoming'));
        

        
//        Router::connect('/admin/:controller',
//                array('controller'=>':controller', 'action'=>'index'));
//        
//        Router::connect('/admin/:controller/:action/*',
//                array('controller'=>':controller', 'action'=>':action'));

	Router::connect('/admin', array('controller' => 'pages', 'action' => 'display', 'home')); //doesn' highlight menu
?>