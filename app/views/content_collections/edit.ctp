<div class="contentCollections form">
<?php                
echo $this->Form->neighborRecords('ContentCollection',$neighbors);
 echo $this->Form->create('ContentCollection');?>
	<fieldset>
 		<legend><?php __('Edit Content Collection'); ?></legend>
	<?php
        $joinLabel = sprintf('Connecting <em>Content %s:</em> %s<br />To <em>Collection %s:</em> %s (%s)', 
                $this->data['Content']['id'],
                $this->data['Content']['heading'],
                $this->data['Collection']['id'],
                $this->data['Collection']['heading'],
                $this->data['Collection']['category']);
        
            $detailLabel = (!is_null($this->data['ContentCollection']['sub_gallery']))
                    ? sprintf('This record leads to detail collection %s: %s.', 
                            $this->data['DetailCollection']['id'],
                            $this->data['DetailCollection']['heading'])
                    : null;
            $detailLabel = (!is_null($detailLabel))
                    ? $this->Html->para(null, $detailLabel)
                    : '';
        
        echo $this->Html->para(null, $joinLabel).$detailLabel.'<br />';
        
		echo $this->Form->input('id');
		echo $this->Form->input('visible',array('type'=>'checkbox'));
		echo $this->Form->input('sub_gallery',array(
                    'options'=>array($detail_collections),
                    'type'=>'select'));
		echo $this->Form->input('content_id');
		echo $this->Form->input('collection_id');
		echo $this->Form->input('seq');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ContentCollection.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContentCollection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>