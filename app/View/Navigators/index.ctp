<div class="navigators index">
<h2><?php echo __('Navigators');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('lft');?></th>
	<th><?php echo $this->Paginator->sort('rght');?></th>
	<th><?php echo $this->Paginator->sort('account');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('publish');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($navigators as $navigator):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $navigator['Navigator']['id']; ?>
		</td>
		<td>
			<?php echo $navigator['Navigator']['parent_id']; ?>
		</td>
		<td>
			<?php echo $navigator['Navigator']['lft']; ?>
		</td>
		<td>
			<?php echo $navigator['Navigator']['rght']; ?>
		</td>
		<td>
			<?php echo $navigator['Navigator']['account']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($navigator['Navline']['name'], array('controller' => 'navlines', 'action' => 'view', $navigator['Navline']['id'])); ?>
		</td>
		<td>
			<?php echo $navigator['Navigator']['publish']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $navigator['Navigator']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $navigator['Navigator']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $navigator['Navigator']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $navigator['Navigator']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Navigator'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php
//debug($test);
?>