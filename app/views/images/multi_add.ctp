<div class="images form">
<?php echo $this->Form->create('Image',array(
    'type' => 'file',
    'url'=>(array ('action'=>'multi_add', $this->params['pass'][0])))) ;?>
    
    <?php for ($count = 0; $count < $this->params['pass'][0]; $count++) { ?>
     
 
	<fieldset>
 		<legend><?php __('Add Image'); ?></legend>
	<?php
		echo $this->Form->input('File',array(
                    'name'=>"data[$count][Image][img_file]",
                    'id' => "{$count}ImageImgFile",
                    'type' => 'file'));
		echo $this->Form->input('Alt',array(
                    'name'=>"data[$count][Image][alt]",
                    'id' => "{$count}ImageImgAlt"));
		echo $this->Form->hidden('PictureDatetime',array(
                    'name'=>"data[$count][Image][picture_datetime]",
                    'id' => "{$count}ImageImgPictureDatetime"));
		echo $this->Form->hidden('Mimetype',array(
                    'name'=>"data[$count][Image][mimetype]",
                    'id' => "{$count}ImageImgMimetype"));
		echo $this->Form->hidden('Filesize',array(
                    'name'=>"data[$count][Image][filesize]",
                    'id' => "{$count}ImageImgFilesize"));
		echo $this->Form->hidden('Width',array(
                    'name'=>"data[$count][Image][width]",
                    'id' => "{$count}ImageImgWidth"));
		echo $this->Form->hidden('Height',array(
                    'name'=>"data[$count][Image][height]",
                    'id' => "{$count}ImageImgHeight"));
                echo $this->Form->input('Gallery', array(
                    'name'=>"data[$count][Image][gallery]",
                    'id' => "{$count}ImageImgGallery",
                    'type'=>'radio', 'value'=>'dispatches', 'options'=> array(
                        'dispatches'=>'Dispatch', 'exhibits'=>'Exhibit' 
                    )
                ));
		echo $this->Form->hidden('Created',array(
                    'name'=>"data[$count][Image][created]",
                    'id' => "{$count}ImageImgCreated",
                    'value'=>time()));
		echo $this->Form->hidden('Modified',array(
                    'name'=>"data[$count][Image][modified]",
                    'id' => "{$count}ImageImgModified",
                    'value'=>time()));
	?>
	</fieldset>
 
   <?php }  ?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('controller' => 'dispatches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
	</ul>
</div>