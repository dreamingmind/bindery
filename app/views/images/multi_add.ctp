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
 * @package       bindery
 * @subpackage    bindery.controller
 * @param int params[pass][0] the number of upload forms to generate
 * @param string params[pass][1] the string 'upload'
 */

$record = array();

?>
<div class="images form">
<?php 

    // One form encloses all records
    echo $this->Form->create('Image',array(
    'type' => 'file',
    'url'=>(array ('action'=>'multi_add')))) ;?>
    
    <?php 
    
    for ($count = 0; $count < $countMax; $count++) { 
        
    if($searchRecords){
        $record = array('record'=>$searchRecords[$count]);
    }
    
    $record['record']['recent_titles'] = $recentTitles;

    ?>
     
    <h2><?php echo (!$searchRecords)?'Add an image':'Replace an image: '.$searchRecords[$count]['Image']['img_file']; ?></h2> 
    
	<?php
        if($searchRecords){
            echo $this->Html->image("images/thumb/x160y120/".$searchRecords[$count]['Image']['img_file']);
//            echo $this->Html->para(null,'Current image: '.$searchRecords[$count]['Image']['img_file']);
            echo $this->Form->input('current_image',array(
                'name'=>"data[$count][Image][current_image]",
                'type'=>'hidden',
                'value'=>$searchRecords[$count]['Image']['img_file']
            ));
        }
        // This is the control to keep or delete the disallowed file
        // Either can happen whether or not a replacement file is uploaded
        if($searchInput == 'disallowed'){
            echo $this->Html->tag('h3',key($disallowed) . ' ('.current($disallowed)->reason.')');
            echo $this->Form->input('Task', array(
                'name'=>"data[$count][Image][task]",
                'id' => "{$count}ImageImgTask",
                'value'=>'delete',
                'type'=>'radio', 'options'=> array(
                    'delete'=>'Delete', 'maintain'=>'Maintain'
                )
            ));
            echo $this->Form->input('disallowed_file', array(
                'type'=>'hidden',
                'name'=>"data[$count][Image][disallowed_file]",
                'value'=> key($disallowed)
            ));
            echo $this->Html->tag('h3','Upload an alternate.');
            next($disallowed);
        }
        
        $params = array(
            'legend'=>'Meta Fields',
            'display'=>'hide',
            'prefix'=>array($count),
            'model'=>'Image'
        ) + $record;

        echo $this->element('imageForm_metaFields',$params);

        $params['legend']='File to upload';
        if(isset($fileError[$count])){
            $params['legend'].="<br />$fileError[$count]";
        }
        $params['display'] = 'show';
        echo $this->Fieldset->fieldset($params+array(
            'fields' => array ('img_file'=>array(
                'type'=>'file'
            ))
        ));
        echo $this->element('imageForm_dataFields',$params);
	?>
   <?php } // End of record output loop  ?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
	</ul>
</div>