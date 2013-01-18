<div class="contentCollections view">
<h2><?php  __('Content Collection');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Publish'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['publish']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Detail Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['DetailCollection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['DetailCollection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['Content']['heading'], array('controller' => 'contents', 'action' => 'view', $contentCollection['Content']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['Collection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['Collection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Seq'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['seq']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Collection', true), array('action' => 'edit', $contentCollection['ContentCollection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Content Collection', true), array('action' => 'delete', $contentCollection['ContentCollection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contentCollection['ContentCollection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement', true), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Supplements');?></h3>
	<?php if (!empty($contentCollection['Supplement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Image Id'); ?></th>
		<th><?php __('Collection Id'); ?></th>
		<th><?php __('Type'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Content Collection Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($contentCollection['Supplement'] as $supplement):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $supplement['id'];?></td>
			<td><?php echo $supplement['modified'];?></td>
			<td><?php echo $supplement['created'];?></td>
			<td><?php echo $supplement['image_id'];?></td>
			<td><?php echo $supplement['collection_id'];?></td>
			<td><?php echo $supplement['type'];?></td>
			<td><?php echo $supplement['data'];?></td>
			<td><?php echo $supplement['content_collection_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'supplements', 'action' => 'view', $supplement['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'supplements', 'action' => 'edit', $supplement['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'supplements', 'action' => 'delete', $supplement['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $supplement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Supplement', true), array('controller' => 'supplements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
