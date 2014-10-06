<?php
echo $this->Form->create('Part');
foreach ($this->request->data as $index => $record){
	echo '<fieldset>';
	foreach ($record['Part'] as $fname => $field) {
		echo $this->Form->input("$index.Part.$fname", array('value' => $field));
	}
	echo '</fieldset>';
}
echo $this->Form->end('Submit');