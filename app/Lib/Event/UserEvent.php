<?php
App::uses('CakeEventListener', 'Event');
App::uses('User', 'Model');
App::uses('Drawbridge', 'Drawbridge.Model');

/**
 * Description of UserEvent
 *
 * @author dondrake
 */
class UserEvent implements CakeEventListener {
		
    public function implementedEvents() {
        return array(
            'Drawbridge.newRegisteredUser' => 'newRegisteredUser'
        );
    }
    
    public function newRegisteredUser($event) {
        $user = ClassRegistry::init('Drawbridge');
        $event->subject->registered_user = $user->data = array('User' => array(
            'id' => $event->data['id'],
            'username' => $event->data['username'],
            'active' => 1,
            'registration_date' => date('Y-m-d h:i:s'),
            'group_id' => 3,
            'email' => $event->data['username'],
            'Group' => array('id' => 3)
        ));
        $user->save($user->data);
        
    }

}
