<?php
	$this->append('scripts');
	echo $this->Html->script('registration');
	echo $this->Html->script('passwordstrength');
	$this->end();
?>

<div class="users form" id="<?php echo $mode; // edit or register. key to javascripts password/email handling ?>">
<?php echo $this->Session->flash();
//debug($this->model);
//        $model = $this->model; //model name
        echo $this->Form->create();?>
	<fieldset>
            <legend><?php echo ucwords($mode);?></legend>
<?php //echo $this->Form->end('Submit');?>
            <?php echo $this->Form->submit(); ?>
	<?php
		echo "<fieldset>\n";
                echo "<legend>";
                __('Required Information');
                echo "</legend>";
                echo $this->Form->input('username', array('label'=>'Username '));
                echo "\n</fieldset>\n";

		echo "<fieldset id='emailBlock'>\n";
                echo $this->Form->input('email', array('label'=>'Email '));
		echo $this->Form->input('repeat_email',
                        array('label'=>'Verify Email <span id="emailError" class="message"></span>', 'div'=>'required'));
                echo $this->Form->input('eMatch', array('type'=>'hidden', 'value'=>'false'));

                if ($mode == 'edit') {
                    echo $this->Form->input('eUse', array('type'=>'hidden', 'value'=>"$EUse"));
                }
                echo "\n</fieldset>\n";

		echo "<fieldset id='passwordBlock'>\n";
		echo $this->Form->input('password', array('label' => 'Password ', 'length'=>'80', 'type'=>'password', 'div'=>'required'));
		echo $this->Form->input('repeat_password',
                        array('label'=>'Verify Password <span id="passwordError" class="message"></span>', 'type'=>'password','length'=>'80', 'div' => 'required'));
                echo $this->Form->input('pMatch', array('type'=>'hidden', 'value'=>'false'));

                if ($mode == 'edit') {
                    echo $this->Form->input('pUse', array('type'=>'hidden', 'value'=>"$PUse"));
                }
                echo "\n</fieldset>\n";

		echo "<fieldset>\n";
                echo "<legend>";
                __('Optional Information');
                echo "</legend>";
		echo $this->Form->input('first_name', array('label'=>'First Name'));
		echo $this->Form->input('last_name', array('label'=>'Last Name'));
		echo $this->Form->input('address', array('label'=>'Address 1'));
		echo $this->Form->input('address2', array('label'=>'Address2'));
		echo $this->Form->input('city', array('label'=>'City'));
		echo $this->Form->input('state', array('label'=>'State'));
		echo $this->Form->input('zip', array('label'=>'Zip'));
		echo $this->Form->input('country', array('label'=>'Country'));
		echo $this->Form->input('phone', array('label'=>'Phone'));
		echo $this->Form->input('fax', array('label'=>'Fax'));
                echo $this->Form->hidden('id', array('label', 'Try to spoof a record id'));
                echo $this->Form->input('group_id', array('type'=>'hidden'));
                echo $this->Form->hidden('registration_date');
                echo "\n</fieldset>\n";
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
    <?php //echo debug($this->viewVars['company']);
     //debug($this->request->data);?>
    <?php //echo debug($referer); ?>
</div>
