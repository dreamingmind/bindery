<div class="users index">
<h2><?php __('Users');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id').'<br />'.$paginator->sort('city').'<br />'.$paginator->sort('fax');?></th>
	<th><?php echo $paginator->sort('email').'<br />'.$paginator->sort('state').'<br />'.$paginator->sort('country');?></th>
	<th><?php echo $paginator->sort('username').'<br />'.$paginator->sort('zip').'<br />'.$paginator->sort('address');?></th>
	<th><?php echo $paginator->sort('group_id').'<br />'.$paginator->sort('email_verified').'<br />'.$paginator->sort('address2');?></th>
	<th><?php echo $paginator->sort('password').'<br />'.$paginator->sort('registration_date').'<br />'.__('Actions');?></th>
	<th><?php echo $paginator->sort('first_name').'<br />'.$paginator->sort('verification_code').'<br />'.$paginator->sort('active');?></th>
	<th><?php echo $paginator->sort('last_name').'<br />'.$paginator->sort('ip');?></th>
	<th><?php echo $paginator->sort('created').'<br />'.$paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('modified').'<br />'.$paginator->sort('phone');?></th>

	<!--<th><?php echo $paginator->sort('city');?></th>-->
	<!--<th><?php echo $paginator->sort('state');?></th>-->
	<!--<th><?php echo $paginator->sort('zip');?></th>-->
	<!--<th><?php echo $paginator->sort('email_verified');?></th>-->
	<!--<th><?php echo $paginator->sort('registration_date');?></th>-->
	<!--<th><?php echo $paginator->sort('verification_code');?></th>-->
	<!--<th><?php echo $paginator->sort('ip');?></th>-->
	<!--<th><?php echo $paginator->sort('phone');?></th>-->
	<!--<th><?php echo $paginator->sort('fax');?></th>-->
	<!--<th><?php echo $paginator->sort('country');?></th>-->
	<!--<th><?php echo $paginator->sort('address');?></th>-->
	<!--<th><?php echo $paginator->sort('address2');?></th>-->
	<!--<th class="actions"><?php __('Actions');?></th>-->
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
			<?php echo $html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
		</td>
                <td>
			<?php echo $user['User']['active']; ?>
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
		<li><?php echo $html->link(__('New User', true), array('action' => 'add')); ?></li>
	</ul>
</div>
