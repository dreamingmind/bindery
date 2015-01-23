<!-- Elements/account_tools.ctp | AppController->before loads account_tools.css -->
		<?php echo $this->Html->accountTool_($userdata); // creates DIV id=accountTool ?>
		<?php echo $this->element('Cart/wish_badge'); ?>
		<?php echo $this->element('Cart/cart_badge'); ?>
<!-- END Elements/account_tools.ctp END -->
