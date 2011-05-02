<div class="navlines index">
	<h2><?php __('Navlines');?></h2>
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('route');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($navlines as $navline):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $navline['Navline']['id']; ?>&nbsp;</td>
		<td><?php echo $navline['Navline']['name']; ?>&nbsp;</td>
		<td><?php echo $navline['Navline']['route']; ?>&nbsp;</td>
		<td><?php echo $navline['Navline']['created']; ?>&nbsp;</td>
		<td><?php echo $navline['Navline']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $navline['Navline']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $navline['Navline']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $navline['Navline']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $navline['Navline']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Navline', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Navigators', true), array('controller' => 'navigators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator', true), array('controller' => 'navigators', 'action' => 'add')); ?> </li>
	</ul>
</div>