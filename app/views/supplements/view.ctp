<div class="supplements view">
<h2><?php  __('Supplement');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $supplement['Supplement']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $supplement['Supplement']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $supplement['Supplement']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $supplement['Supplement']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $supplement['Supplement']['data']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($supplement['ContentCollection']['Content.heading'], array('controller' => 'content_collections', 'action' => 'view', $supplement['ContentCollection']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Supplement', true), array('action' => 'edit', $supplement['Supplement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Supplement', true), array('action' => 'delete', $supplement['Supplement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $supplement['Supplement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>
