<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * Images view
 * 
 * the first url parameter sets the number of upload forms to create
 * If there no second parameter, the system will allow uploads from any directory
 * If there is a second parameter it must be 'upload'. That will trigger the inclusion
 * of the hidden field 'batch=1' and that will directly handle files from the Upload folder
 * 
 * @todo make the upload folder examination process actually work. right now it's just a proof of concept using the upload parameter
 * @package       bindery
 * @subpackage    bindery.controller
 * @param int params[pass][0] the number of upload forms to generate
 * @param string params[pass][1] the string 'upload'
 */
if($disallowed && (!isset($this->params['pass'][0]))){
    $countMax = count($disallowed);
//    debug($disallowed);
    current($disallowed);
} else {
    $countMax = $this->params['pass'][0];
}
?>
<div class="images form">
<?php echo $this->Form->create('Image',array(
    'type' => 'file',
    'url'=>(array ('action'=>'multi_add', $countMax)))) ;?>
    
    <?php for ($count = 0; $count < $countMax; $count++) { ?>
     
 
	<fieldset>
 		<legend><?php __('Add Image'); ?></legend>
	<?php
        if($disallowed && !isset($this->params['pass'][0])){
            echo $this->Html->tag('h3',key($disallowed) . ' ('.current($disallowed)->reason.')');
            next($disallowed);
                echo $this->Form->input('Task', array(
                    'name'=>"data[$count][Image][task]",
                    'id' => "{$count}ImageImgTask",
                    'value'=>'delete',
                    'type'=>'radio', 'options'=> array(
                        'delete'=>'Delete', 'maintain'=>'Maintain'
                    )
                ));
           echo $this->Html->tag('h3','Upload an alternate.');
        }
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
                    if (isset($this->params['pass'][1])) { 
		echo $this->Form->hidden('batch',array(
                    'name'=>"data[$count][Image][batch]",
                    'id' => "{$count}ImageImgBatch",
                    'value'=>1));                        
                    }
	?>
	</fieldset>
 
   <?php }  ?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
	</ul>
</div>