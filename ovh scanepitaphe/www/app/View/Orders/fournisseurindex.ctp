<div class="row minha">
	<?php echo $this->element('bordadminf'); ?>
    <div class="small-12 medium-8 large-8 columns">
	<h4><?php echo __('Liste des commandes Scanepitaphe');?></h4>

<table>
	<tr>
		<th><?php echo __('Date');?></th>
		<th><?php echo __('Reference de la commande');?></th>
		<th><?php echo __('Nom du client');?></th>
		<th><?php echo __('Montant');?></th>
	</tr>
<!-- Here is where we loop through our $posts array, printing out post info -->
<?php foreach ($orderlist as $order): ?>
	<tr>
		<td><?php echo $order['Order']['created']; ?></td>
		<td><?php echo $this->Html->link($order['Order']['cleref'],array('controller'=>'orders','action'=>'fournisseurview',$order['Order']['id'])); ?></td>
		<td><?php echo $order['Order']['uname']; ?></td>
		<td><?php echo $order['Order']['ttc']; ?></td>
	</tr>
<?php endforeach; ?>
<?php unset($order); ?>

</table>
</div>
</div>
