<script type="text/javascript">
    $(document).ready(function(){
        $('#DrawbridgeUsername').trigger('focus');
    });
</script>
<?php
echo $this->Form->create();
echo $this->Form->input('username', array(
    'label' => 'Email',
    'tabindex' => 1
));
echo $this->Form->input('password', array(
    'tabindex' => 2
));
echo $this->Form->end('Login');