<div class="navigators view">
<h2><?php echo __('Navigator');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lft'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['lft']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rght'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['rght']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Account'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['account']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Navline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($navigator['Navline']['name'], array('controller' => 'navlines', 'action' => 'view', $navigator['Navline']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Navigator'), array('action' => 'edit', $navigator['Navigator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Navigator'), array('action' => 'delete', $navigator['Navigator']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $navigator['Navigator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Navigators'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
