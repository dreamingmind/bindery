<?php  ?>
<div id='tree_admin'>
    <div id='tree_view'>
        <p>Nodes are presented "PrimaryKey: DisplayField"<br />
        and are indented to indicate the tree sturcture.</p>
<?php
	$row = 1;
 	foreach($this->data['treeCrudList']['tree'] as $key => $treeLine) {
            $treeLine = "&nbsp;$treeLine";//"$key&nbsp;$treeLine";
            $rowClass = ($row++ % 2 == 1) ? 'odd' : 'even';
            echo $html->tag('p', $treeLine, array('class' => $rowClass)), "\n";
	}
?>
    </div>

<div id='tree_control'>
	
<?php

        $newNameFunctions =  $this->TreeCrud->newNameJavascript('-r') . $this->TreeCrud->newNameJavascript('-e');
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

    // make 'new' and existing name selectors toggle so only one has value
    // Rename pair first
    {$newNameFunctions}

 });

 // function to reveal the radio button choice that is select
 // when the page redisplays after some input error
 function showme() {
    $('div#liveFunction > fieldset').prependTo('div#functionPool').hide(200);
    $('div#liveFunction').html($('fieldset[id ~= \''+$('input:radio[name="data[{$this->data['primaryModel']}][action]"]:checked').val()+'\']').show(200));
 }
JSC;
        $js->buffer($code);
        $js->buffer($js->get("fieldset[class*='function']")->each('$(this).hide();'));
        $js->buffer('showme();'); //make sure any selected radio button reveals its form on page refresh

        $params = '';
        if (isset($this->params['named']['lft'])&& isset($this->params['named']['rght'])) {
            $params = '/lft:'.$this->params['named']['lft'].'/rght:'.$this->params['named']['rght'];
        }
	echo $form->create($model_name, array(
            'action' => 'manage_tree'.$params
                ));

	// radio button array of tree editing options
	$options=array(
		'd'=>'Delete', 
		'u'=>'Up', 
		'w'=>'Down', 
		'r'=>'Rename', 
		'e'=>'New Element', 
		'p'=>'To Parent',
                'f'=>'Focus'
	);
	$attributes=array('legend'=> 'Select a function', 'id' => 'rad_func');
	echo "\n" . $form->radio('action',$options, $attributes) . "<br />";
?>
    <div id="liveFunction"><fieldset></fieldset></div>

<?php echo $form->end(); ?>

    <div id='functionPool'>
        <?php
        $this->TreeCrud->deleteForm();
        echo "<!-- DELETE FUNCTION -->\n";
        echo $this->TreeCrud->deleteFormStart;
        if(isset($delete_inputs)){
            echo $delete_inputs;
        }
        echo $this->TreeCrud->deleteFormEnd;

        $this->TreeCrud->focusForm();
        echo "<!-- FOCUS FUNCTION -->\n";
        echo $this->TreeCrud->focusFormStart;
        if(isset($focus_inputs)){
            echo $focus_inputs;
        }
        echo $this->TreeCrud->focusFormEnd;

        $this->TreeCrud->upForm();
        echo "<!-- UP FUNCTIONS -->\n";
        echo $this->TreeCrud->upFormStart;
        if(isset($up_inputs)){
            echo $up_inputs;
        }
        echo $this->TreeCrud->upFormEnd;

        $this->TreeCrud->downForm();
        echo "<!-- DOWN FUNCTIONS -->\n";
        echo $this->TreeCrud->downFormStart;
        if(isset($down_inputs)){
            echo $down_inputs;
        }
        echo $this->TreeCrud->downFormEnd;

        $this->TreeCrud->renameForm();
        echo "<!-- RENAME FUNCTION -->\n";
        echo $this->TreeCrud->renameFormStart;
        if(isset($rename_inputs)){
            echo $rename_inputs;
        }
        echo $this->TreeCrud->renameFormEnd;

        $this->TreeCrud->newForm();
        echo "<!-- NEW ELEMENT FUNCTION -->\n";
        echo $this->TreeCrud->newFormStart;
        if(isset($new_inputs)){
            echo $new_inputs;
        }
        echo $this->TreeCrud->newFormEnd;

        $this->TreeCrud->parentForm();
	echo "<!-- NEW PARENT FOR ELEMENT FUNCTION -->\n";
        echo $this->TreeCrud->parentFormStart;
        if(isset($parent_inputs)){
            echo $parent_inputs;
        }
        echo $this->TreeCrud->parentFormEnd; ?>
    </div>

</div>

<div id='tree_post'>
    <?php

    //debug($this->params);
    ?>
</div>
</div>