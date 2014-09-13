<div class="contents view">
<h2><?php echo __('Content');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['content']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($content['Image']['img_file'], array('controller' => 'images', 'action' => 'view', $content['Image']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Alt'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['alt']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Heading'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $content['Content']['heading']; ?>
			&nbsp;
		</dd>
		<!--<dt<?php // if ($i % 2 == 0) echo $class;?>><?php // __('Publish'); ?></dt>-->
<!--		<dd<?php // if ($i++ % 2 == 0) echo $class;?>>
			<?php // echo $content['Content']['publish']; ?>
			&nbsp;
		</dd>-->
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content'), array('action' => 'edit', $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Content'), array('action' => 'delete', $content['Content']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Exhibit Supliments');?></h3>
	<?php if (!empty($content['ExhibitSupliment'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Img File');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['img_file'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Heading');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['heading'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Prose');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['prose'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Prose T');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['prose_t'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Top Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['top_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Left Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['left_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Height Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['height_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Width Val');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['width_val'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Headstyle');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['headstyle'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Pgraphstyle');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['pgraphstyle'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['modified'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Alt');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['alt'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Image Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['image_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Mimetype');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['mimetype'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Filesize');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['filesize'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Width');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['width'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Height');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['height'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Exhibit Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['exhibit_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Content Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $content['ExhibitSupliment']['content_id'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Exhibit Supliment'), array('controller' => 'exhibit_supliments', 'action' => 'edit', $content['ExhibitSupliment']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php echo __('Related Content Collections');?></h3>
	<?php if (!empty($content['ContentCollection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Visible'); ?></th>
		<th><?php echo __('Sub Gallery'); ?></th>
		<th><?php echo __('Content Id'); ?></th>
		<th><?php echo __('Collection Id'); ?></th>
		<th><?php echo __('Seq'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($content['ContentCollection'] as $contentCollection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $contentCollection['created'];?></td>
			<td><?php echo $contentCollection['modified'];?></td>
			<td><?php echo $contentCollection['id'];?></td>
			<td><?php echo $contentCollection['visible'];?></td>
			<td><?php echo $contentCollection['sub_gallery'];?></td>
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
