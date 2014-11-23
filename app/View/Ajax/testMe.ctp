<?php
echo $this->Form->create();
echo $this->Form->input('x');
echo $this->Form->input('y');
echo $this->Form->radio('mode', array('coordinate', 'vector'));

echo $this->Form->input('angle');
echo $this->Form->input('distance');
echo $this->Form->radio('mode', array('coordinate', 'vector'));
echo $this->Form->end('Submit');