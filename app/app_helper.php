<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'Helper', 'Session');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper {
    function output($str) {
        echo $str . "\n";
    }

    function accountTool($userdata) {
        $tool = "<div id='accountTool'><p>";
        if (isset($userdata) && $userdata != 0) {
            $tool .= $userdata['username'] . " | ";
            $tool .= HtmlHelper::link('Log Out', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'logout'));
        } else {
            $tool .= HtmlHelper::link('Log In', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'login'));
            $tool .= ' | ';
            $tool .= HtmlHelper::link('Register', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'register'));
        }
        return $tool . "</p></div>";
    }

    function siteSearch() {
        $tool = "<div id='siteSearch'>";
        $tool .= "<input type=\"text\" value=\" Search\"
            onblur=\"if(this.value==''){ this.value=' Search'; }\"
            onfocus=\"if(this.value==' Search'){ this.value=''; }\"
            class=\"search_input\" name=\"q\">";
        //'<label>Search<input name="data[search]" type="text" Label="Search" size="50px" id="search" /></label>';
        //FormHelper::input('search', array('Label'=>'Search', 'size'=>'50px'));
        return $tool . "</div>";
    }
    
    function neighborRecords($model, $neighbors) {
        //print_r($neighbors);        print_r($model);
        $tools = '';
        if(isset($neighbors['prev'][$model]['id'])) { 
            $tools .= HtmlHelper::link(__('Previous',true), array($neighbors['prev']['Dispatch']['id'])); 
        }
        if (isset($neighbors['prev'][$model]['id']) && isset($neighbors['next']['Dispatch']['id'])) {
            $tools .= '&nbsp;|&nbsp;';
        }
        if(isset($neighbors['next'][$model]['id'])) {
            $tools .= HtmlHelper::link(__('Next',true), array($neighbors['next']['Dispatch']['id']));
        }
        $tools = ($tools == '') ? 'nothing' : $tools;
        return $tools;
    }
    
}
?>