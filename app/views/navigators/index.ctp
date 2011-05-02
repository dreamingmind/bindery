<div class="navigators index">
<h2><?php __('Navigators');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('lft');?></th>
	<th><?php echo $paginator->sort('rght');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('navline_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
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
			<?php echo $html->link($navigator['Navline']['name'], array('controller' => 'navlines', 'action' => 'view', $navigator['Navline']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $navigator['Navigator']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $navigator['Navigator']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $navigator['Navigator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $navigator['Navigator']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Navigator', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Navlines', true), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Navline', true), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php
//debug($test);
?>