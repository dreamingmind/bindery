<div class="users form">
    <p>
        User Account Page</ br>
        This page will include links to modify user account settings, user gallerys and past orders
		
		And either show past orders or link to the Design/Order page which has them, or something else.
    </p>>
    <?php
        echo $this->Html->link(__('Change email, password or address'), array('action' => 'edit', $userid));
//        debug($userdata);
//        debug($data);
    ?>
</div>
