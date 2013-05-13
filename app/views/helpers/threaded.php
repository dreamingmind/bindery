<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.com)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Data
 */
/**
 * Threaded Helper
 * 
 * @package       bindery
 * @subpackage    bindery.Data
 */
class ThreadedHelper extends AppHelper {
    var $helpers = array('Html');
    var $row = 0;
    
    function output_threaded($thread_array, $indent = '&nbsp;&nbsp;&nbsp;', $lead = null) {
        $lead = ($lead == null) ? $indent : $lead.$indent;
        
        foreach ($thread_array as $key=>$level) {
            $treeLine = "{$level['Acos']['id']}$lead{$level['Acos']['alias']}";
            $rowClass = ($this->row++ % 2 == 1) ? 'odd' : 'even';
            echo $this->Html->tag('p', $treeLine, array('class' => $rowClass)) . "\n";
            $this->output_threaded($level['children'], $indent, $lead);
        }
    }
}
?>