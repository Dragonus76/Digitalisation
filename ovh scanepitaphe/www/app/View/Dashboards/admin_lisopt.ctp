<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>

	
    <div class="small-12 medium-8 large-8 columns">
	<h2>Gestion des paramètres du site Scanepitaphe (Titre, description, mots clés)</h2>
		<?php foreach ($options as $key => $option): ?>

		<?php
		echo $this->Html->link($option['Option']['name'],
						array('controller'=>'options','action' => 'edit', $option['Option']['id'])
						); 
		?><br/>
		<?php endforeach; ?>
	</div>
</div>