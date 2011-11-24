<div class="dispatches view">
<h2><?php  __('Dispatch');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Img File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['img_file']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('News Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['news_text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gallery'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['gallery']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Publish'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['publish']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Alt'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['alt']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dispatch['Dispatch']['image_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dispatch', true), array('action' => 'edit', $dispatch['Dispatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Dispatch', true), array('action' => 'delete', $dispatch['Dispatch']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dispatch['Dispatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php __('Related Images');?></h3>
	<?php if (!empty($dispatch['Image'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Img File');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['img_file'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Height Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['height_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Width Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['width_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['modified'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mimetype');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['mimetype'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Filesize');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['filesize'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Width');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['width'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Height');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $dispatch['Image']['height'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Image', true), array('controller' => 'images', 'action' => 'edit', $dispatch['Image']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php __('Related Galleries');?></h3>
	<?php if (!empty($dispatch['Gallery'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Label'); ?></th>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($dispatch['Gallery'] as $gallery):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $gallery['name'];?></td>
			<td><?php echo $gallery['label'];?></td>
			<td><?php echo $gallery['id'];?></td>
			<td><?php echo $gallery['created'];?></td>
			<td><?php echo $gallery['modified'];?></td>
			<td><?php echo $gallery['description'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'galleries', 'action' => 'view', $gallery['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'galleries', 'action' => 'edit', $gallery['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'galleries', 'action' => 'delete', $gallery['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gallery['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
