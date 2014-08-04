<div class="users index">
<h2><?php echo __('Users');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id').'<br />'.$this->Paginator->sort('city').'<br />'.$this->Paginator->sort('fax');?></th>
	<th><?php echo $this->Paginator->sort('email').'<br />'.$this->Paginator->sort('state').'<br />'.$this->Paginator->sort('country');?></th>
	<th><?php echo $this->Paginator->sort('username').'<br />'.$this->Paginator->sort('zip').'<br />'.$this->Paginator->sort('address');?></th>
	<th><?php echo $this->Paginator->sort('group_id').'<br />'.$this->Paginator->sort('email_verified').'<br />'.$this->Paginator->sort('address2');?></th>
	<th><?php echo $this->Paginator->sort('password').'<br />'.$this->Paginator->sort('registration_date').'<br />'.__('Actions');?></th>
	<th><?php echo $this->Paginator->sort('first_name').'<br />'.$this->Paginator->sort('verification_code').'<br />'.$this->Paginator->sort('active');?></th>
	<th><?php echo $this->Paginator->sort('last_name').'<br />'.$this->Paginator->sort('ip');?></th>
	<th><?php echo $this->Paginator->sort('created').'<br />'.$this->Paginator->sort('phone');?></th>
	<th><?php echo $this->Paginator->sort('modified').'<br />'.$this->Paginator->sort('phone');?></th>

	<!--<th><?php echo $this->Paginator->sort('city');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('state');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('zip');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('email_verified');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('registration_date');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('verification_code');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('ip');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('phone');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('fax');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('country');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('address');?></th>-->
	<!--<th><?php echo $this->Paginator->sort('address2');?></th>-->
	<!--<th class="actions"><?php echo __('Actions');?></th>-->
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['group_id']; ?>
		</td>
		<td>
			<?php echo $user['User']['password']; ?>
		</td>
		<td>
			<?php echo $user['User']['first_name']; ?>
		</td>
		<td>
			<?php echo $user['User']['last_name']; ?>
		</td>
		<td>
			<?php echo $user['User']['created']; ?>
		</td>
		<td>
			<?php echo $user['User']['modified']; ?>
                </td></tr><tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['city']; ?>
		</td>
		<td>
			<?php echo $user['User']['state']; ?>
		</td>
		<td>
			<?php echo $user['User']['zip']; ?>
		</td>
		<td>
			<?php echo $user['User']['email_verified']; ?>
		</td>
		<td>
			<?php echo $user['User']['registration_date']; ?>
		</td>
		<td>
			<?php echo $user['User']['verification_code']; ?>
		</td>
		<td>
			<?php echo $user['User']['ip']; ?>
		</td>
		<td>
			<?php echo $user['User']['phone']; ?>
		</td></tr><tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['fax']; ?>
		</td>
		<td>
			<?php echo $user['User']['country']; ?>
		</td>
		<td>
			<?php echo $user['User']['address']; ?>
		</td>
		<td>
			<?php echo $user['User']['address2']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $user['User']['id'])); ?>
		</td>
                <td>
			<?php echo $user['User']['active']; ?>
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
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
	</ul>
</div>
