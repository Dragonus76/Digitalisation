<div class="row minha">
	<?php echo $this->element('bordadminf'); ?>
    <div class="small-12 medium-8 large-8 columns">
	<h4>Commande n°<?php echo $order['Order']['cleref'];?> - <?php echo $this->Html->link('<i class="fa fa-print"></i>',array('controller'=>'orders','action'=>'fournisseurpview',$order['Order']['id']), array(
                    'escapeTitle' => false, 'title' => 'imprimer la commande'
                  )); ?></h4>
	<h6>Coordonnées du client</h6>
	<p>
		<?php
			echo $order['Order']['ufirstname'].' '.$order['Order']['uname'];
			echo '<br/>';
			echo $order['Order']['ustreet'];
			echo '<br/>';
			echo $order['Order']['uzipcode'].' '.$order['Order']['ucity'];
			echo '<br/>';
			echo $order['Order']['ucountry'];
			echo '<br/>';
			echo 'Tel : '.$order['Order']['uphone'];
		?>
	</p>
	<h6>Coordonnées de livraison</h6>
	<p>
		<?php
			echo $order['Order']['dfirstname'].' '.$order['Order']['dname'];
			echo '<br/>';
			echo $order['Order']['dstreet'];
			echo '<br/>';
			echo $order['Order']['dzipcode'].' '.$order['Order']['dcity'];
			echo '<br/>';
			echo $order['Order']['dcountry'];
			echo '<br/>';
			echo 'Tel : '.$order['Order']['dphone'];
		?>
	</p>
	<h6>Commande</h6>
	<p>
		<?php
			echo 'Date : '.$order['Order']['created'];
			echo '<br/>';
			if(!empty($order['Order']['statut'])){echo 'Statut : '.$order['Order']['statut'];}
			
		?>
	</p>
	<h6>Colissimo</h6>
	<p>
		<?php
			echo $this->Form->create('Order');
            echo $this->Form->input('id', array('type' => 'hidden'));
            echo $this->Form->input('colissimo',array('label' => 'Indiquer le numéro Colissimo', 'placeholder'=>'renseignez le numéro colissimo','class' => 'ckeditor'));
            echo $this->Form->submit('Enregistrer',array('class'=>'button postfix')); 
            echo $this->Form->end();
		?>
	</p>

	<?php 
		$products = explode("&",$order['Order']['listproduct']);
		$prices = explode("&",$order['Order']['listprice']);
	?>

	<table>
		<tr>
			<th>Liste des produits commandés</th>
			<th>Prix</th>
		</tr>
		<tr>
			<td>
				<?php
					foreach ($products as $key => $value) {
						echo $value.'<br/>';
					}			
				?>
			</td>
			<td>
				<?php
					foreach ($prices as $key => $value) {
						echo $value.'<br/>';
					}				
				?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo 'Livraison : '.$order['Order']['livraison'].' €'; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo 'Total TVA : '.$order['Order']['tva'].' €'; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo 'Total TTC : '.$order['Order']['ttc'].' €'; ?></td>
		</tr>
	</table>

	<h6>Liste produits matériels</h6>
	<?php if(!empty($array)): ?>
	<table>
		<tr>
			<th>Nom du produit</th>
			<th>Personne concernée</th>
			<th>Image</th>
			<th>QR code</th>
		</tr>
		<?php
			foreach ($array as $key => $value) {
				$numkey = explode('/',$value['Image']);
				
				echo '<tr>';
					echo '<td>'.$value['Product'].'</td>';
					echo '<td>'.$value['Defunt']['firstname'].' '.$value['Defunt']['name'].'</td>';
					$nomqr = $value['Defunt']['firstname'].'_'.$value['Defunt']['name'];
					$fileb = $value['Filname'];
					echo '<td>'.$this->Html->image(substr($value['Image'],35),array(
						'url' => array('controller' => 'orders', 'action' => 'sendfilejpg',$order['Order']['id'],$numkey['9'],$fileb, $nomqr
							))).'</td>';
					$fichierqr= $value['Defunt']['id'];					
					echo '<td>'.$this->Html->image('defunts/defunt_'.$value['Defunt']['id'].'/qrcode_'.$value['Defunt']['id'].'.png').'</td>';
				echo '</tr>';
			}
		?>
	</table>
<?php else : ?>
	<p>Commande de la version 1. Impossible d'afficher le détail.</p>
<?php endif ?>

	</div>
</div>
