<?php
echo $this->Html->image('transparent.png', array('height' => '100px'));
echo $this->Html->link('Clear contents', array('action' => 'clear', $this->request->params['pass'][0]), array(), 'Are you sure you want to clear the contents of this log?');
$d = preg_replace('/(.*\n)/', '<p>$1</p>', $out);
echo $d;
