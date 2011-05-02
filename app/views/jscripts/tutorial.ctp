        <a href="http://jquery.com/" class-'bigtime'>jQuery</a>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$js->buffer($js->get('a')->event('click',$js->effect('hide', array('speed'=>'slow'))));
//$js->buffer($js->get('a'));
//$js->buffer("$('a').addClass('test');");
//$js->get('a');
$js->buffer($js->get('a')->each('$(this).addClass("test");'));

?>
