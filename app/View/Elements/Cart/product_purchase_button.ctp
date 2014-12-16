<?php
	echo $this->Form->button(($purchaseCount > 0) ? $this->Cart->submitItemButtonLabel($purchaseCount): 'Order now', array('type' => 'submit', 'class' => 'submit', 'bind' => $this->Cart->submitItemButtonBehavior()));
