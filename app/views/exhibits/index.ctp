<div class="exhibits index">
	<h2><?php __('Exhibits');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('img_file');?></th>
			<th><?php echo $this->Paginator->sort('heading');?></th>
			<th><?php echo $this->Paginator->sort('prose_t');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('top_val');?></th>
			<th><?php echo $this->Paginator->sort('left_val');?></th>
			<th><?php echo $this->Paginator->sort('height_val');?></th>
			<th><?php echo $this->Paginator->sort('width_val');?></th>
			<th><?php echo $this->Paginator->sort('headstyle');?></th>
			<th><?php echo $this->Paginator->sort('pgraphstyle');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('alt');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($exhibits as $exhibit):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
            <td rowspan="2"><?php echo $exhibit['Exhibit']['img_file']; ?>&nbsp;</td>
		<td rowspan="2"><?php echo $exhibit['Exhibit']['heading']; ?>&nbsp;</td>
		<td rowspan="2"><?php echo $exhibit['Exhibit']['prose_t']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['id']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['top_val']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['left_val']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['height_val']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['width_val']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['headstyle']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['pgraphstyle']; ?>&nbsp;</td>
		<td><?php echo $exhibit['Exhibit']['modified']; ?>&nbsp;</td>
		<td rowspan="2"><?php echo $exhibit['Exhibit']['alt']; ?>&nbsp;</td>
		<td ><?php echo $exhibit['Exhibit']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $exhibit['Exhibit']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $exhibit['Exhibit']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $exhibit['Exhibit']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $exhibit['Exhibit']['id'])); ?>
		</td>
	</tr>
        <tr>
            <td colspan="7"><?php echo $this->Html->image('exhibits'.DS.'thumb'.DS.'x320y240'.DS.$exhibit['Exhibit']['img_file']) ?></td>
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
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Exhibit', true)), array('action' => 'add')); ?></li>
	</ul>
</div>