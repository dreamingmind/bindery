<?php //debug($this->params);
    //debug($this->passedArgs); ?>
<div id='tree_admin'>
	<div id='tree_view'>
<?php
//	$row = 1;
// 	foreach($tree as $key => $treeLine) {
//		$treeLine = "$key&nbsp;$treeLine";
//		$rowClass = ($row++ % 2 == 1) ? 'odd' : 'even';
//		echo $html->tag('p', $treeLine, array('class' => $rowClass)), "\n";
//	}
    $threaded->output_threaded($tree, '.....');
?>
	</div>

<div id='tree_control'>
	
<?php 
	echo $html->css('form');

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
        $js->buffer($code);

	echo $form->create('TreeAcos', array('action' => 'manage_tree'));

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
	echo "\n" . $form->radio('action',$options, $attributes) . "<br />";
        ?>

    <div id="liveFunction"><fieldset></fieldset></div>

        <?php
        echo $form->end('Change Tree');

        // Hide each of the fieldsets. They all have class='function'
        $js->buffer($js->get("fieldset[class*='function']")->each('$(this).hide();'));

	?>

    <div id='functionPool'>
        <!-- DELETE FUNCTION
            use nameList select -->
	<fieldset id='d' class="function">
		<?php
		echo $html->tag('legend', 'Delete function');
		// echo $html->tag('h3','ID: '. $this->data['Navigator']['id']) . $cr;
                echo $form->label('Delete');
		echo $form->select('deleteLine', $lineNames, $id) . $cr;
                ?>
	</fieldset>

	<!-- UP/DOWN FUNCTIONS
            use delta select and nameList select -->
	<fieldset id="u w" class="function">
		<?php
		// number of steps to move the element
		echo $html->tag('legend', 'UpDown function');
                echo "\n" . $form->input('delta', array('options'=>$delta, 'default'=>'-1'));
                echo $form->label('Line to move');
		echo $form->select('moveLine', $lineNames, $id) . $cr;
                ?>
	</fieldset>

	<!-- RENAME FUNCTION
            use nameList select and newName text input -->
	<fieldset id="r" class="function">
		<?php
		// number of steps to move the element
		echo $html->tag('legend', 'Rename function');
                echo $form->label('Line to rename');
		echo $form->select('oldName', $lineNames, $id) . $cr;
		echo $form->input("newName", array('type'=>'text', 'label'=>'New name'));
		?>
	</fieldset>


	<!-- NEW ELEMENT FUNCTION
            use nameList select and newName text input -->
	<fieldset id="e" class="function">
		<?php
		// number of steps to move the element
		echo $html->tag('legend', 'New element function');
                echo $form->label('Parent');
		echo $form->select('parent', $lineNames, $id) . $cr;
		echo $form->input("newElement", aa('type', 'text', 'label', 'New name'));
		?>
	</fieldset>

	<fieldset id="p" class="function">
		<?php
		// number of steps to move the element
		echo $html->tag('legend', 'Move to new parent function');
                echo $form->label('New Parent');
		echo $form->select('newParent', $lineNames, $id) . $cr;
                echo $form->label('Child to move');
		echo $form->select('child', $lineNames, $id) . $cr;
		?>
	</fieldset>
    </div>

</div>

<div id='tree_post'>

</div>
</div>