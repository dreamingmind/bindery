<?php
echo '<h1>   </h1>';
echo $this->Form->create(NULL, array('type' => 'file'));
echo $this->Form->input('QBFile', array('type' => 'file'));
echo $this->Form->end('Submit');
