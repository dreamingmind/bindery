<div class="users form" id="<?php echo $mode; // edit or register. key to javascripts password/email handling ?>">
<?php echo $session->flash();
//debug($this->model);
//        $model = $this->model; //model name
        echo $form->create($this->model);?>
	<fieldset>
            <legend><?php echo ucwords($mode);?></legend>
<?php //echo $form->end('Submit');?>
            <?php echo $form->submit(); ?>
	<?php
		echo "<fieldset>\n";
                echo "<legend>";
                __('Required Information');
                echo "</legend>";
                echo $form->input('username', array('label'=>'Username '));
                echo "\n</fieldset>\n";

		echo "<fieldset id='emailBlock'>\n";
                echo $form->input('email', array('label'=>'Email '));
		echo $form->input('repeat_email',
                        array('label'=>'Verify Email <span id="emailError" class="message"></span>', 'div'=>'required'));
                echo $form->input('eMatch', array('type'=>'hidden', 'value'=>'false'));

                if ($mode == 'edit') {
                    echo $form->input('eUse', array('type'=>'hidden', 'value'=>"$EUse"));
                }
                echo "\n</fieldset>\n";

		echo "<fieldset id='passwordBlock'>\n";
		echo $form->input('password', array('label' => 'Password ', 'length'=>'80', 'type'=>'password', 'div'=>'required'));
		echo $form->input('repeat_password',
                        array('label'=>'Verify Password <span id="passwordError" class="message"></span>', 'type'=>'password','length'=>'80', 'div' => 'required'));
                echo $form->input('pMatch', array('type'=>'hidden', 'value'=>'false'));

                if ($mode == 'edit') {
                    echo $form->input('pUse', array('type'=>'hidden', 'value'=>"$PUse"));
                }
                echo "\n</fieldset>\n";

		echo "<fieldset>\n";
                echo "<legend>";
                __('Optional Information');
                echo "</legend>";
		echo $form->input('first_name', array('label'=>'First Name'));
		echo $form->input('last_name', array('label'=>'Last Name'));
		echo $form->input('address', array('label'=>'Address 1'));
		echo $form->input('address2', array('label'=>'Address2'));
		echo $form->input('city', array('label'=>'City'));
		echo $form->input('state', array('label'=>'State'));
		echo $form->input('zip', array('label'=>'Zip'));
		echo $form->input('country', array('label'=>'Country'));
		echo $form->input('phone', array('label'=>'Phone'));
		echo $form->input('fax', array('label'=>'Fax'));
                echo $form->hidden('id', array('label', 'Try to spoof a record id'));
                echo $form->input('group_id', array('type'=>'hidden'));
                echo $form->hidden('registration_date');
                echo "\n</fieldset>\n";
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
    <?php //echo debug($this->viewVars['company']);
     //debug($this->data);?>
    <?php //echo debug($referer); ?>
</div>
<?php
        $code = <<< JSC
$(document).ready(function() {
// set the trigger functions and defaults to check the emails
    var email       = $('#UserEmail');
    var re_email    = $('#UserRepeatEmail');
    $(email).blur(function() {
        matchEmail();
    });
    $(re_email).blur(function() {
        matchEmail();
    });

    if (re_email.val() == email.val() && email.val() != '') {
        $('#UserEMatch').val('true');
    } else {
	$('#UserEMatch').val('false');
    }

// set the trigger functions to check the passwords
    var pass       = $('#UserPassword');
    var re_pass    = $('#UserRepeatPassword');
    $(pass).blur(function() {
        matchPassword();
    });
    $(re_pass).blur(function() {
        matchPassword();
    });
    
    if (re_pass.val() == pass.val() && pass.val() != '') {
        $('#UserPMatch').val('true');
    } else {
	$('#UserPMatch').val('false');
    }

// detect edit vs register state and
// run email/password suppression for edit mode
// use .slideUp() to hide and .slideDown() to show
    var mode = $('#edit');
    if (mode.length != 0) {
        if ($('#UserEUse').val() == 'false') {
            //alert('initEmailState');
            initEditEmailState();
        }
        if ($('#UserPUse').val() == 'false') {
            //alert('initPasswordState');
            initEditPasswordState();
        }
    }

    // in Account/edit, false will keep these from being validated and changes will be ignored.
    // in User/register these have no effect
    //$('#UserPUse').val('false'); // in edit mode password may be in play (true) or hidden (false)
    //$('#UserEUse').val('false'); // in edit mode password may be in play (true) or hidden (false)


}); // ***** END OF READY FUNCTION *****

 //visiblity toggle event for "Edit" state
 function initEditEmailState() {
    originalEmail = $('#UserEmail').val();
    //alert(originalEmail);
    eb = $('#emailBlock');
    eb.children('div').slideUp();
    eb.append('<a>Change Email ({$this->data[$model]['email']})</a>')
    newE = eb.children('a');
    newE.click(toggleEmail);
 }

 //visiblity toggle event for "Edit" state
 function initEditPasswordState() {
    pb = $('#passwordBlock')
    pb.children('div').slideUp();
    pb.append('<a>Change Password (Encrypted. Cannot be viewed.)</a>')
    newP = pb.children('a');
    newP.click(togglePassword);
 }

 function toggleEmail() {
    //alert('toggleEmail');
    if ($('#emailBlock').children('a').text() == 'Cancel change') {
      $('#emailBlock').children('div').slideUp();
      $('#emailBlock').children('a').text('Change Email ({$this->data[$model]['email']})');
      $('#UserEmail').val(originalEmail);
      $('#UserRepeatEmail').val(originalEmail);
      $('#UserEUse').val('false');
    } else {
      //alert('reveal email');
      $('#emailBlock').children('div').slideDown();
      $('#emailBlock').children('a').text('Cancel change');
      $('#UserEUse').val('true');
    }
}
 
 function togglePassword() {
     //alert('togglePassword');
   if ($('#passwordBlock').children('a').text() == 'Cancel change') {
      $('#passwordBlock').children('div').slideUp();
      $('#passwordBlock').children('a').text('Change Password (Stored in encrypted format. Can be reset but not be retrieved.)');
      $('#UserPassword').val('');
      $('#UserRepeatPassword').val('');
      $('#UserPUse').val('false');
    } else {
      $('#passwordBlock').children('div').slideDown();
      $('#passwordBlock').children('a').text('Cancel change');
      $('#UserPUse').val('true');
    }
}

// Compare the emails to verify a match
// **** TO DO ****
// Check db for uniqueness of input - ajax function
 function matchEmail() {
    var email       = $('#UserEmail').val();
    var re_email    = $('#UserRepeatEmail').val();
    var visit       = $('#UserEmailVisit').val();
    if (email == '' && re_email == '') {
        $('#emailError').html('');
        $('#UserEMatch').val('false');
    } else if (email != '' && re_email == '') {
        $('#emailError').html('Type your email again to insure accuracy');
        $('#UserEMatch').val('false');
    } else if (email != re_email) {
	$('#emailError').html('The email addresses don\'t match.');
        $('#UserEMatch').val('false');
    } else {
	$('#emailError').html('');
        $('#UserEMatch').val('true');
    }
 }

// Compare the passwords to verify a match
 function matchPassword() {
    var pass       = $('#UserPassword').val();
    var re_pass    = $('#UserRepeatPassword').val();
    var visit       = $('#UserPasswordVisit').val();
    if (pass == '' && re_pass == '') {
        //$('#UserPasswordVisit').val(true);
	$('#passwordError').html('');
        $('#UserPMatch').val('false');
    } else if (pass != '' && re_pass == '') {
        //$('#UserPasswordVisit').val(true);
	$('#passwordError').html('Type your password again to insure accuracy.');
        $('#UserPMatch').val('false');
    } else if (pass != re_pass) {
	$('#passwordError').html('The passwords don\'t match.');
        $('#UserPMatch').val('false');
    } else {
	$('#passwordError').html('');
        $('#UserPMatch').val('true');
    }
 }


    $('#UserPassword').password_strength();

JSC;
        $passwordChecker = file_get_contents(WWW_ROOT . 'js' . DS . 'passwordstrength.js');
        //$js->buffer($passwordChecker);
        $js->buffer($passwordChecker . $code);
?>