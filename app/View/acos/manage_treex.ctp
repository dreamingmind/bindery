<?php //debug($this->request->params);
    //debug($this->passedArgs); ?>
<div id='tree_admin'>
	<div id='tree_view'>
<?php
//	$row = 1;
// 	foreach($tree as $key => $treeLine) {
//		$treeLine = "$key&nbsp;$treeLine";
//		$rowClass = ($row++ % 2 == 1) ? 'odd' : 'even';
//		echo $this->Html->tag('p', $treeLine, array('class' => $rowClass)), "\n";
//	}
    $this->Threaded->output_threaded($tree, '.....');
?>
	</div>

<div id='tree_control'>
	
<?php 
	echo $this->Html->css('form');

        // Add 'change' action to these radio buttons.
        // Take the value of the clicked option and
        // remove class-'hide' from the field set of the
        // same id as the radio button
        
        $code = <<< JSC
$(document).ready(function() {
    $('input:radio').each(
        function(){
           $(this).change(
                 function(){
                    //alert($(this).val());
                    $('div#liveFunction > fieldset').prependTo('div#functionPool').hide(200);
                    $('div#liveFunction').html($('fieldset[id ~= \''+$(this).val()+'\']').show(200));
                 }
           );
        }
    );
 });
JSC;
        $this->Js->buffer($code);

	echo $this->Form->create('TreeAcos', array('action' => 'manage_tree'));

	// radio button array of tree editing options
	$options=array(
		'd'=>'Delete', 
		'u'=>'Up', 
		'w'=>'Down', 
		'r'=>'Rename', 
		'e'=>'New Element', 
		'p'=>'To Parent'
	);
	$attributes=array('legend'=> 'Select a function', 'id' => 'rad_func');
	echo "\n" . $this->Form->radio('action',$options, $attributes) . "<br />";
        ?>

    <div id="liveFunction"><fieldset></fieldset></div>

        <?php
        echo $this->Form->end('Change Tree');

        // Hide each of the fieldsets. They all have class='function'
        $this->Js->buffer($this->Js->get("fieldset[class*='function']")->each('$(this).hide();'));

	?>

    <div id='functionPool'>
        <!-- DELETE FUNCTION
            use nameList select -->
	<fieldset id='d' class="function">
		<?php
		echo $this->Html->tag('legend', 'Delete function');
		// echo $this->Html->tag('h3','ID: '. $this->request->data['Navigator']['id']) . $cr;
                echo $this->Form->label('Delete');
		echo $this->Form->select('deleteLine', $lineNames, $id) . $cr;
                ?>
	</fieldset>

	<!-- UP/DOWN FUNCTIONS
            use delta select and nameList select -->
	<fieldset id="u w" class="function">
		<?php
		// number of steps to move the element
		echo $this->Html->tag('legend', 'UpDown function');
                echo "\n" . $this->Form->input('delta', array('options'=>$delta, 'default'=>'-1'));
                echo $this->Form->label('Line to move');
		echo $this->Form->select('moveLine', $lineNames, $id) . $cr;
                ?>
	</fieldset>

	<!-- RENAME FUNCTION
            use nameList select and newName text input -->
	<fieldset id="r" class="function">
		<?php
		// number of steps to move the element
		echo $this->Html->tag('legend', 'Rename function');
                echo $this->Form->label('Line to rename');
		echo $this->Form->select('oldName', $lineNames, $id) . $cr;
		echo $this->Form->input("newName", array('type'=>'text', 'label'=>'New name'));
		?>
	</fieldset>


	<!-- NEW ELEMENT FUNCTION
            use nameList select and newName text input -->
	<fieldset id="e" class="function">
		<?php
		// number of steps to move the element
		echo $this->Html->tag('legend', 'New element function');
                echo $this->Form->label('Parent');
		echo $this->Form->select('parent', $lineNames, $id) . $cr;
		echo $this->Form->input("newElement", aa('type', 'text', 'label', 'New name'));
		?>
	</fieldset>

	<fieldset id="p" class="function">
		<?php
		// number of steps to move the element
		echo $this->Html->tag('legend', 'Move to new parent function');
                echo $this->Form->label('New Parent');
		echo $this->Form->select('newParent', $lineNames, $id) . $cr;
                echo $this->Form->label('Child to move');
		echo $this->Form->select('child', $lineNames, $id) . $cr;
		?>
	</fieldset>
    </div>

</div>

<div id='tree_post'>

</div>
</div>