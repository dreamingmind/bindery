<?php
App::uses('CakeEventListener', 'Event');
App::uses('User', 'Model');

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
        $user = ClassRegistry::init('User');
        dmDebug::logVars($user->Behaviors, 'user behaviors');
        dmDebug::logVars(get_class_methods('User'), 'getClassMethods');
        $user->data = array('User' => array(
            'id' => $event->data['id'],
            'active' => 1,
            'registration_date' => date('Y-m-d h:i:s'),
            'group_id' => 3,
            'email' => $event->data['username']
        ));
        dmDebug::logVars($user->data, 'user data');
        $user->save($user->data, array(
            'callbacks' => false
        ));
        
    }

}
