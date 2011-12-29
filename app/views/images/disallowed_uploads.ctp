<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);
echo $session->flash();
?>
<div class="images form">
<?php 
if($disallowed) {

    $count = 0;
    
    foreach($disallowed as $file => $object) { 
        
        echo $this->Html->para('',$object->info['basename']);
        echo $this->Html->para('',$object->reason);

    $count++; 
    
    
    }
    }  
?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
	</ul>
</div>