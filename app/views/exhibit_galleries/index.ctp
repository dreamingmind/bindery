<div class="exhibitGalleries index">
	<h2><?php __('Exhibit Galleries');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('lft');?></th>
			<th><?php echo $this->Paginator->sort('rght');?></th>
			<th><?php echo $this->Paginator->sort('exhibit_id');?></th>
			<th><?php echo $this->Paginator->sort('seq');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('gallery_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($exhibitGalleries as $exhibitGallery):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $exhibitGallery['ExhibitGallery']['parent_id']; ?>&nbsp;</td>
		<td><?php echo $exhibitGallery['ExhibitGallery']['lft']; ?>&nbsp;</td>
		<td><?php echo $exhibitGallery['ExhibitGallery']['rght']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($exhibitGallery['Exhibit']['heading'], array('controller' => 'exhibits', 'action' => 'view', $exhibitGallery['Exhibit']['id'])); ?>
		</td>
		<td><?php echo $exhibitGallery['ExhibitGallery']['seq']; ?>&nbsp;</td>
		<td><?php echo $exhibitGallery['ExhibitGallery']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($exhibitGallery['Gallery']['label'], array('controller' => 'galleries', 'action' => 'view', $exhibitGallery['Gallery']['id'])); ?>
		</td>
                <td><?php echo $this->Html->image('exhibits'.DS.'thumb'.DS.'x54y54'.DS.$exhibitGallery['Exhibit']['img_file']); ?>&nbsp;</td>
		<!-- <td><?php echo $exhibitGallery['ExhibitGallery']['created']; ?>&nbsp;</td>
		<td><?php echo $exhibitGallery['ExhibitGallery']['modified']; ?>&nbsp;</td> -->
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $exhibitGallery['ExhibitGallery']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $exhibitGallery['ExhibitGallery']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $exhibitGallery['ExhibitGallery']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $exhibitGallery['ExhibitGallery']['id'])); ?>
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
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
 
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Exhibit Gallery', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Exhibits', true)), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Exhibit', true)), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Galleries', true)), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Gallery', true)), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
        <?php echo $this->Form->create('ExhibitGallery');?>
            <?php echo $this->Form->input('gallery_id'); ?>
        <?php echo $this->Form->end(__('Filter', true));?>
</div>