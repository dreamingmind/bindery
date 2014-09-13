<div class="collections view">
<h2><?php echo __('Collection');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Heading'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['heading']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Publish'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['publish']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['role']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($collection['Category']['name'], array('controller' => 'categories', 'action' => 'view', $collection['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $collection['Collection']['slug']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Collection'), array('action' => 'edit', $collection['Collection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Collection'), array('action' => 'delete', $collection['Collection']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $collection['Collection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Content Collections');?></h3>
	<?php if (!empty($collection['ContentCollection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Publish'); ?></th>
		<th><?php echo __('Sub Collection'); ?></th>
		<th><?php echo __('Content Id'); ?></th>
		<th><?php echo __('Collection Id'); ?></th>
		<th><?php echo __('Seq'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($collection['ContentCollection'] as $contentCollection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contentCollection['created'];?></td>
			<td><?php echo $contentCollection['modified'];?></td>
			<td><?php echo $contentCollection['id'];?></td>
			<td><?php echo $contentCollection['publish'];?></td>
			<td><?php echo $contentCollection['sub_slug'];?></td>
			<td><?php echo $contentCollection['content_id'];?></td>
			<td><?php echo $contentCollection['collection_id'];?></td>
			<td><?php echo $contentCollection['seq'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'content_collections', 'action' => 'view', $contentCollection['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'content_collections', 'action' => 'edit', $contentCollection['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'content_collections', 'action' => 'delete', $contentCollection['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $contentCollection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
