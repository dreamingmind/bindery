<div class="categories index">
	<h2><?php echo __('Categories');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('supplement_list');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($categories as $category):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $category['Category']['id']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['modified']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['created']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['name']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['description']; ?>&nbsp;</td>
                <?php if (str_word_count($category['Category']['supplement_list'])>1){ 
//                    echo str_word_count($category['Category']['supplement_list']);?>
                <td><pre><?php print_r(unserialize($category['Category']['supplement_list'])); ?>&nbsp;</pre></td>
                <?php } ?>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $category['Category']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>