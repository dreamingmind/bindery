<?php //debug($this->params);
    //debug($this->passedArgs); ?>
<div id='tree_admin'>
	<div id='tree_view'>
<?php
	$row = 1;
 	foreach($tree as $key => $treeLine) {
		$treeLine = "$key&nbsp;$treeLine";
		$rowClass = ($row++ % 2 == 1) ? 'odd' : 'even';
		echo $html->tag('p', $treeLine, array('class' => $rowClass)), "\n";
	}
//    echo $this->output_threaded($tree);
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
// make the radio button set show/hide the various associated specific-use forms
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
    // make 'new' and existing name selectors toggle so only one has value
    // Rename pair first
    $('#RenameNewName').change(
        function() {
           $('#RenameNameId').val('0');
        }
    );
    $('#RenameNameId').change(
        function() {
           $('#RenameNewName').val('');
        }
    );
    // Now the New pair
    $('#NewNewName').change(
        function() {
           $('#NewNameId').val('0');
        }
    );
    $('#NewNameId').change(
        function() {
           $('#NewNewName').val('');
        }
    );
 });
JSC;
        $js->buffer($code);

	echo $form->create('Navigator', array('action' => 'manage_tree'));

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
        <?php
        echo $form->create('Delete', array('action'=>'manage_tree', 'class'=>'function')), "\n";
        ?>
	<fieldset id='d' class="function">
        <?php
            echo $html->tag('legend', 'Delete'), "\n";
            echo $form->input('id', array('type'=>'select','options'=>$lineNames, 'label'=>'Element to delete')), "\n";
            echo $form->button('Delete'), "\n";
        ?>
	</fieldset>
        <?php
        echo $form->end();
        ?>

	<!-- UP FUNCTIONS -->
        <?php
        echo $form->create('Up', array('action'=>'manage_tree', 'class'=>'function')), "\n";
        ?>
	<fieldset id="u" class="function">
            <?php
            echo $html->tag('legend', 'Move Up'), "\n";
            echo $form->input('id', array('type'=>'select','options'=>$lineNames, 'label'=>'Element to move')), "\n";
            echo $form->input('delta', array('label'=>'Steps')), "\n";
            echo $form->button('Move up'), "\n";
            ?>
	</fieldset>
        <?php
        echo $form->end(), "\n";
        ?>

	<!-- DOWN FUNCTIONS -->
        <?php
        echo $form->create('Down', array('action'=>'manage_tree', 'class'=>'function'));
        ?>
	<fieldset id="w" class="function">
        <?php
            echo $html->tag('legend', 'Move Down');
            echo $form->input('id', array('type'=>'select','options'=>$lineNames, 'label'=>'Element to move'));
            echo $form->input('delta', array('label'=>'Steps'));
            echo $form->button('Move down'), "\n";
        ?>
	</fieldset>
        <?php
        echo $form->end();
        ?>

	<!-- RENAME FUNCTION -->
        <?php
        echo $form->create('Rename', array('action'=>'manage_tree', 'class'=>'function'));
        ?>
	<fieldset id="r" class="function">
        <?php
            echo $html->tag('legend', 'Rename');
            echo $form->input('id', array('type'=>'select','options'=>$lineNames, 'label'=>'Element to rename'));
            echo $form->input('new_name', array('label'=>'New name'));
            if ($foreign_name) {
                echo $form->input('name_id', array('type'=>'select', 'options'=>$names, 'label'=>'Available names'));
            }
            echo $form->button('Rename'), "\n";
        ?>
	</fieldset>
        <?php
        echo $form->end(), "\n";
        ?>

	<!-- NEW ELEMENT FUNCTION -->
        <?php
        echo $form->create('New', array('action'=>'manage_tree', 'class'=>'function'));
        ?>
	<fieldset id="e" class="function">
		<?php
            echo $html->tag('legend', 'New Element');
            echo $form->input('parent_id', array('type'=>'select','options'=>$lineNames, 'label'=>'Parent element'));
            echo $form->input('new_name', array('label'=>'New name'));
            if ($foreign_name) {
                echo $form->input('name_id', array('type'=>'select', 'options'=>$names, 'label'=>'Available names'));
            }
            echo $form->button('New Element'), "\n";
        ?>
	</fieldset>
        <?php
        echo $form->end(), "\n";
	?>

        <?php
        echo $form->create('parent', array('action'=>'manage_tree', 'class'=>'function'));
        ?>
	<fieldset id="p" class="function">
        <?php
            echo $html->tag('legend', 'New Parent');
            echo $form->input('id', array('type'=>'select','options'=>$lineNames, 'label'=>'Element'));
                echo $form->input('parent_id', array('type'=>'select','options'=>$lineNames, 'label'=>'New Parent'));
            echo $form->button('New Parent'), "\n";
	?>
	</fieldset>
    </div>

</div>

<div id='tree_post'>
    <?php
    //debug($this->data);
    ?>
</div>
</div>