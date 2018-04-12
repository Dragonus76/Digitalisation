<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns nopuce">
    	<h2>Liste des produits du Scanshop</h2>
    	<?php if(empty($products)) :?>
    	<p>La boutique est vide.<br/><?php echo $this->Html->link('Ajouter un produit',array('controller'=>'products','action'=>'add'),array('title'=>'ajouter un produit')); ?></p>
    <?php else: ?>
		<ul>
			<?php foreach ($products as $product): ?>
				<li><?php echo $this->Html->link($product['Product']['name'],array('controller'=>'products','action'=>'edit',$product['Product']['id']),array('title'=>'modifier ce produit')); ?> - <?php echo $this->Html->link("Supprimer ce produit",array('controller'=>'products','action'=>'delete',$product['Product']['id']),null,'Voulez vous vraiment supprimer ce produit ? Cette action est DEFINITIVE.'); ?></li>
			<?php endforeach; ?>
			<?php unset($post); ?>
			<li>&nbsp;</li>
			<li>__________</li>
			<li>&nbsp;</li>
			<li><?php echo $this->Html->link('Ajouter un produit',array('controller'=>'products','action'=>'add'),array('title'=>'ajouter un produit')); ?></li>
		</ul>
	<?php endif ?>
	</div>
</div>