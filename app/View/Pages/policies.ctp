<?php ?>
<h1>Policies</h1>
<h2>Account information</h2>
<p>A unique User Name containing only letters and numbers, unique Email Address and a Password of at least 8 charcters are the only pieces of required information to create and account. You may provide me with the other requested contact information if you wish.
No credit card or other financial information is stored on this site. Credit card payments are accepted through your PayPal account.</p>
<?php 
if (!isset($username) || !$username) {
    echo $this->Html->link(__('Create an account now'), array('controller' => 'users', 'action' => 'register'));
}
?>
<h3>Password</h3>
<p>To ensure security your Password is stored in an encrypted form. If you forget what it is, it can't be recoved but there are links on the Login page that will allow you to have a new password emailed to you.
If you have your password reset in this way I recommend you edit your accout information to reset it to a value of your choice immediately.
</p>
<h3>Protecting your account information</h3>
<p>Once logged in, you will be able to veiw images of your project as it is being made and images of your past project if I have posted them.
    If you want to edit your account information, you will be asked to enter your password even though you are logged in. This is to help protect your information should someone have access to your computer while you are still logged into my site.<br />
<?php 
if (isset($username)) {
    echo $this->Html->link(__('Edit your account information now'), array('controller' => 'accounts', 'action' => 'edit'));
}
?>
</p>
<h3>Options related to your project images</h3>
<p>All options for publishing your images are Opt-In, meaning they won't be allowed unless you specifically request them.
As always, there is one exception. If you are registered for a workshop, you will automatically receive its notification emails.</p>
<p>When new images of your projects are posted, you can recieve email notification<br />
<?php 
if (isset($username)) {
    echo $this->Html->link(__('Change this setting now'), array('controller' => 'accounts', 'action' => 'opt_in'));
}
?>
</p>
<p>You can allow people who search the site with your name to find your project images<br />
You might choose this if you have friends or family that would like to follow the progress of your project. Unless you specifically told someone they could do this,
it's very unlikely anyone would stumble on your project images. And there is no personal information linked to these images besides the name they are associated with.
If you choose this option but haven't provided your name in your account settings, you'll need to add that information<br />
<?php 
if (isset($username)) {
    echo $this->Html->link(__('Change this setting now'), array('controller' => 'accounts', 'action' => 'opt_in'));
}
?>
</p>
<h3>Workshop notifications</h3>
<p>You can receive information about upcoming workshops<br />
<?php 
if (isset($username)) {
    echo $this->Html->link(__('Change this setting now'), array('controller' => 'accounts', 'action' => 'opt_in'));
}
?>
<br />If you're registered for a workshop, you'll automatically receive notifications related to it. You can't opt of these.</p>


<?php
//        debug($userdata);
//        debug($data);
?>
