<div class="users form">
    <p>
        User Account Page</ br>
        This page will include links to modify user account settings, user gallerys and past orders
    </p>>
    <?php
        echo $this->Html->link(__('Change email, password or address'), array('action' => 'edit', $userid));
//        debug($userdata);
//        debug($data);
    ?>
</div>
