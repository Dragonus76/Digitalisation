<script type="text/javascript"> 
<!-- 
function BoutonDroit() 
{ 
if((event.button==2)||(event.button==3)||(event.button==4)) 
alert(__('Le bouton droit de la souris à été desactivé')); 
} 
document.onmousedown=BoutonDroit; 

//--> 
</script>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Commande n°');?><?php echo $order['Order']['cleref'];?> - <?php echo $this->Html->link('<i class="fa fa-print"></i>',array('controller'=>'orders','action'=>'pview',$order['Order']['id']), array(
                    'escapeTitle' => false, 'title' => __('format pour imprimer la commande'),'target'=>'_blank'
                  )); ?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                __('Retour à la page précédente'),
                                $this->request->referer(),
                                array('title'=>__('bouton pour revenir à la page précédente'))
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 lignetop">
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
			echo __('Tel : ').$order['Order']['uphone'];
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
			echo __('Tel : ').$order['Order']['dphone'];
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

		</tr>
		<?php
			foreach ($array as $key => $value) {
				$numkey = explode('/',$value['Image']);
				
				echo '<tr>';
					echo '<td>'.$value['Product'].'</td>';
					echo '<td>'.$value['Defunt']['firstname'].' '.$value['Defunt']['name'].'</td>';
					$nomqr = $value['Defunt']['firstname'].'_'.$value['Defunt']['name'];
					$fileb = $value['Filname'];
					echo '<td>'.$this->Html->image(substr($value['Image'],35)).'</td>';

				echo '</tr>';
			}
		?>
	</table>
<?php else : ?>
	<p><?php echo __('Commande de la version 1. Impossible d\'afficher le détail.');?></p>
<?php endif ?>
	
      </div>
	</div>
</div>
