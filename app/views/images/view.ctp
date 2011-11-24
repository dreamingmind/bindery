<div class="images view">
<h2><?php  __('Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Img File'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['img_file']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Height Val'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['height_val']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Width Val'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['width_val']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mimetype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['mimetype']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Filesize'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['filesize']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Width'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['width']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Height'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $image['Image']['height']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Image', true), array('action' => 'edit', $image['Image']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Image', true), array('action' => 'delete', $image['Image']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $image['Image']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('controller' => 'dispatches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Dispatches');?></h3>
	<?php if (!empty($image['Dispatch'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Img File'); ?></th>
		<th><?php __('News Text'); ?></th>
		<th><?php __('Gallery'); ?></th>
		<th><?php __('Publish'); ?></th>
		<th><?php __('Alt'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Image Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($image['Dispatch'] as $dispatch):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $dispatch['id'];?></td>
			<td><?php echo $dispatch['img_file'];?></td>
			<td><?php echo $dispatch['news_text'];?></td>
			<td><?php echo $dispatch['gallery'];?></td>
			<td><?php echo $dispatch['publish'];?></td>
			<td><?php echo $dispatch['alt'];?></td>
			<td><?php echo $dispatch['modified'];?></td>
			<td><?php echo $dispatch['created'];?></td>
			<td><?php echo $dispatch['date'];?></td>
			<td><?php echo $dispatch['image_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'dispatches', 'action' => 'view', $dispatch['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'dispatches', 'action' => 'edit', $dispatch['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'dispatches', 'action' => 'delete', $dispatch['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dispatch['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Exhibits');?></h3>
	<?php if (!empty($image['Exhibit'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Img File'); ?></th>
		<th><?php __('Heading'); ?></th>
		<th><?php __('Prose'); ?></th>
		<th><?php __('Prose T'); ?></th>
		<th><?php __('Id'); ?></th>
		<th><?php __('Top Val'); ?></th>
		<th><?php __('Left Val'); ?></th>
		<th><?php __('Height Val'); ?></th>
		<th><?php __('Width Val'); ?></th>
		<th><?php __('Headstyle'); ?></th>
		<th><?php __('Pgraphstyle'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Alt'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Image Id'); ?></th>
		<th><?php __('Mimetype'); ?></th>
		<th><?php __('Filesize'); ?></th>
		<th><?php __('Width'); ?></th>
		<th><?php __('Height'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($image['Exhibit'] as $exhibit):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $exhibit['img_file'];?></td>
			<td><?php echo $exhibit['heading'];?></td>
			<td><?php echo $exhibit['prose'];?></td>
			<td><?php echo $exhibit['prose_t'];?></td>
			<td><?php echo $exhibit['id'];?></td>
			<td><?php echo $exhibit['top_val'];?></td>
			<td><?php echo $exhibit['left_val'];?></td>
			<td><?php echo $exhibit['height_val'];?></td>
			<td><?php echo $exhibit['width_val'];?></td>
			<td><?php echo $exhibit['headstyle'];?></td>
			<td><?php echo $exhibit['pgraphstyle'];?></td>
			<td><?php echo $exhibit['modified'];?></td>
			<td><?php echo $exhibit['alt'];?></td>
			<td><?php echo $exhibit['created'];?></td>
			<td><?php echo $exhibit['image_id'];?></td>
			<td><?php echo $exhibit['mimetype'];?></td>
			<td><?php echo $exhibit['filesize'];?></td>
			<td><?php echo $exhibit['width'];?></td>
			<td><?php echo $exhibit['height'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'exhibits', 'action' => 'view', $exhibit['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exhibits', 'action' => 'edit', $exhibit['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exhibits', 'action' => 'delete', $exhibit['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $exhibit['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
