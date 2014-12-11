<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RobotNotification
 *
 * @author jasont
 */
class RobotNotificationShell extends AppShell {
    public function main() {
		$this->requestAction('notices/cron/send/' . $this->args[0]);
    }
}