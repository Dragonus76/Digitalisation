<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns nopuce">
    	<h2>Liste des modes de livraison</h2>
    	<?php if(empty($deliveries)) :?>
    	<p>Aucun mode de livraison créé.<br/><?php echo $this->Html->link('Ajouter un mode de livraison',array('controller'=>'deliveries','action'=>'add'),array('title'=>'ajouter un mode de livraison')); ?></p>
    <?php else: ?>
		<ul>
			<?php foreach ($deliveries as $delivery): ?>
				<li><?php echo $this->Html->link($delivery['Delivery']['name'],array('controller'=>'deliveries','action'=>'edit',$delivery['Delivery']['id']),array('title'=>'modifier ce mode de livraison')); ?> - <?php echo $this->Html->link("Supprimer ce mode de livraison",array('controller'=>'deliveries','action'=>'delete',$delivery['Delivery']['id']),null,'Voulez vous vraiment supprimer ce mode de livraison ? Cette action est DEFINITIVE.'); ?></li>
			<?php endforeach; ?>
			<?php unset($post); ?>
			<li>&nbsp;</li>
			<li>__________</li>
			<li>&nbsp;</li>
			<li><?php echo $this->Html->link('Ajouter un mode de livraison',array('controller'=>'deliveries','action'=>'add'),array('title'=>'ajouter un mode de livraison')); ?></li>
		</ul>
	<?php endif ?>
	</div>
</div>