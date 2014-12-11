<div class="designs view">
<h2><?php echo __('Design');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $design['Design']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $design['Design']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $design['Design']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($design['User']['username'], array('controller' => 'users', 'action' => 'view', $design['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Design Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $design['Design']['product_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<pre><?php print_r(unserialize($design['Design']['data'])); ?></pre>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Supplement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($design['Supplement']['id'], array('controller' => 'supplements', 'action' => 'view', $design['Supplement']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Design'), array('action' => 'edit', $design['Design']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Design'), array('action' => 'delete', $design['Design']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $design['Design']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Designs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Design'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>
