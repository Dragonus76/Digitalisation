<div class="row minha">
	<h4><?php echo __('Commande n°');?><?php echo $order['Order']['cleref'];?></h4>
	<h6><?php echo __('Coordonnées du client');?></h6>
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
	<h6><?php echo __('Coordonnées de livraison');?></h6>
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
	<h6><?php echo __('Commande');?></h6>
	<p>
		<?php
			echo __('Date : ').$order['Order']['created'];
			echo '<br/>';
			if(!empty($order['Order']['statut'])){echo __('Statut : ').$order['Order']['statut'];}
			
		?>
	</p>

	<?php 
		$products = explode("&",$order['Order']['listproduct']);
		$prices = explode("&",$order['Order']['listprice']);
	?>

	<table>
		<tr>
			<th><?php echo __('Liste des produits commandés');?></th>
			<th><?php echo __('Prix');?></th>
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
			<td><?php echo __('Livraison : ').$order['Order']['livraison'].' €'; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo __('Total TVA : ').$order['Order']['tva'].' €'; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo __('Total TTC : ').$order['Order']['ttc'].' €'; ?></td>
		</tr>
	</table>

	<h6><?php echo __('Liste produits matériels');?></h6>
	<?php if(!empty($array)): ?>
	<table>
		<tr>
			<th><?php echo __('Nom du produit');?></th>
			<th><?php echo __('Personne concernée');?></th>
			<th><?php echo __('Image');?></th>
			<th><?php echo __('QR code');?></th>
		</tr>
		<?php
			foreach ($array as $key => $value) {
				echo '<tr>';
					echo '<td>'.$value['Product']['name'].'</td>';
					echo '<td>'.$value['Defunt']['firstname'].' '.$value['Defunt']['name'].'</td>';
					$nomqr = $value['Defunt']['firstname'].'_'.$value['Defunt']['name'];
					$fileb = $value['Filname'];
					echo '<td>'.$this->Html->image(substr($value['Image'],35),array(
						'url' => array('controller' => 'orders', 'action' => 'sendfilejpg',$order['Order']['id'],$key,$fileb, $nomqr
							))).'</td>';
					$fichierqr= $value['Defunt']['id'];					
					echo '<td>'.$this->Html->image('defunts/defunt_'.$value['Defunt']['id'].'/qrcode_'.$value['Defunt']['id'].'.png',array(
						'url' => array('controller' => 'orders', 'action' => 'sendfile',$fichierqr, $nomqr
							))).'</td>';
				echo '</tr>';
			}
		?>
	</table>
<?php else : ?>
	<p><?php echo __('Commande de la version 1. Impossible d\'afficher le détail.');?></p>
<?php endif ?>


</div>
