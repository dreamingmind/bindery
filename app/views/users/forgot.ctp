<?php
/* 
 * For to let user request forgotten username or password via email
 */
if ($mode == 'username') {
    $prompt = 'Your username will be emailed to you. ';
} else {
    $prompt = '</p><p>A temporary password will be emailed. Use it to log in, then go to your account page to change it. ';
}
if (isset($register)) {
    $prompt .= "<h3>" . $html->link('Create an new account', array('action'=>'register')) . "</h3><p>Or try correcting your email address.</p>";
}
echo $form->create('User', array('class'=>'float_form', 'action' => "forgot/$mode", 'id'=>'forgot'));
?>
<legend><h1><?php __("Forgot your $mode?");?></h1></legend>
<p><?php echo 'Enter the email address associated with your Dreaming Mind account, then click continue. '.$prompt ?></p>
    <fieldset>
	<?php
        echo $form->input('email',array('label'=>'Email address'));
        ?>
    </fieldset>
<?php echo $form->end('Continue');?>

