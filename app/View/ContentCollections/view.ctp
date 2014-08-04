<div class="contentCollections view">
<h2><?php echo __('Content Collection');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Publish'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['publish']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Detail Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['DetailCollection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['DetailCollection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['Content']['heading'], array('controller' => 'contents', 'action' => 'view', $contentCollection['Content']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($contentCollection['Collection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['Collection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Seq'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contentCollection['ContentCollection']['seq']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content Collection'), array('action' => 'edit', $contentCollection['ContentCollection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Content Collection'), array('action' => 'delete', $contentCollection['ContentCollection']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $contentCollection['ContentCollection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Supplements');?></h3>
	<?php if (!empty($contentCollection['Supplement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Image Id'); ?></th>
		<th><?php echo __('Collection Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Data'); ?></th>
		<th><?php echo __('Content Collection Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View'), array('controller' => 'supplements', 'action' => 'view', $supplement['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'supplements', 'action' => 'edit', $supplement['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'supplements', 'action' => 'delete', $supplement['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $supplement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
