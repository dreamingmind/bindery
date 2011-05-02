<?php
//debug($this->data);
/*
 * Add javascript code to surpress the
 * Email and Password fieldsets (set them to visibility: 'hide')
 * and insert 'Change' buttons so the user doesn't accidentally
 * mess with these rarely changed fields.
 *
 * If 'Change' is requested visibility changes to 'show' and
 * the button changes to 'Cancel'. A 'Cancel' request
 * cleans up the fields and hides everything again.
 *
 * It seems like a bit of a hack, but:
 * In the 'register.ctp' element javascript, have the
 * ready() function call this set-up function.
 * And in the 'register.ctp' view for User, write this
 * same function but leave it empty.
 *
 * Somewhat better would be to write the routines into
 * the main javascript and have it run or not based
 * on its detection of which context it's in.
 */
echo $this->element('register',
    array('mode' => 'edit',
        'model' => 'User') // pass the form id so javascript knows how to manage password/email fields
);
?>