<div class="navigators view">
<h2><?php  __('Navigator');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lft'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['lft']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rght'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['rght']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navigator['Navigator']['account']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Navline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($navigator['Navline']['name'], array('controller' => 'navlines', 'action' => 'view', $navigator['Navline']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Navigator', true), array('action' => 'edit', $navigator['Navigator']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Navigator', true), array('action' => 'delete', $navigator['Navigator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $navigator['Navigator']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Navigators', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Navigator', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Navlines', true), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Navline', true), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
