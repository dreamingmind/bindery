<div class="message flash success" id="emptyMessage">
	<button type="button" bind="click.closeFlash">×</button>
	<span><?php echo $message; ?></span>
	<p>Continue browsing <?php echo $this->Html->link('the site', array('controller' => 'pages', 'action' => 'home')) ?></p>
</div>
