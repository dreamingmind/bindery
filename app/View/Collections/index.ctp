<div class="collections index">
	<h2><?php echo __('Collections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
<!--			<th><?php // echo $this->Paginator->sort('created');?></th>
			<th><?php // echo $this->Paginator->sort('modified');?></th>-->
			<th><?php echo $this->Paginator->sort('heading');?></th>
			<th><?php echo $this->Paginator->sort('publish');?></th>
			<th><?php echo $this->Paginator->sort('text');?></th>
			<th><?php echo $this->Paginator->sort('role');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($collections as $collection):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $collection['Collection']['id']; ?>&nbsp;</td>
<!--		<td><?php // echo $collection['Collection']['created']; ?>&nbsp;</td>
		<td><?php // echo $collection['Collection']['modified']; ?>&nbsp;</td>-->
		<td><?php echo $collection['Collection']['heading']; ?>&nbsp;<hr>
                <?php echo $collection['Collection']['slug']; ?>&nbsp;</td>
		<td><?php echo $collection['Collection']['publish']; ?>&nbsp;</td>
		<td><?php echo $collection['Collection']['text']; ?>&nbsp;</td>
		<td><?php echo $collection['Collection']['role']; ?>&nbsp;<hr>
                    <?php echo $this->Html->link($collection['Category']['name'], array('controller' => 'categories', 'action' => 'view', $collection['Category']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $collection['Collection']['id'])); ?><br />
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $collection['Collection']['id'])); ?><br />
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $collection['Collection']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $collection['Collection']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Collection'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>