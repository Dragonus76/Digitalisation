<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>

	
    <div class="small-12 medium-8 large-8 columns">
	<h2>Gestion des pages (A propos, CGV, CGU, etc.)</h2>
		<?php foreach ($pages as $key => $page): ?>

		<?php
		echo $this->Html->link($page['Pages']['title'],
						array('controller'=>'pages','action' => 'edit', $page['Pages']['id'])
						); 
		?><br/>
		<?php endforeach; ?>
	</div>
</div>