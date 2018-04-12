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
            <h3><?php echo __('Récapitulatif de votre commande');?></h3>
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
      <div class="small-12 medium-12 large-12 columns">
      	<?php if ($this->Session->read('Cart')): ?>
			

					<?php echo $this->Form->create('Order'); ?>
					<h6><?php echo __('Vos coordonnées');?></h6>
					<p><?php echo __('Nom : ');?><?php echo $order['Order']['uname']; ?>
					<br/>
					<?php echo __('Prénom : ');?><?php echo $order['Order']['ufirstname']; ?>
					<br/>
					<?php echo __('Rue : ');?><?php echo $order['Order']['ustreet']; ?>
					<br/>
					<?php echo __('Code Postal : ');?><?php echo $order['Order']['uzipcode']; ?>
					<br/>
					<?php echo __('Ville : ');?><?php echo $order['Order']['ucity']; ?>
					<br/>
					<?php echo __('Pays : ');?><?php echo $order['Order']['ucountry']; ?>
					<br/>
					<?php echo __('Téléphone : ');?><?php echo $order['Order']['uphone']; ?>
					<br/>
					<?php echo __('Email : ');?><?php echo $order['Order']['uemail']; ?>
					</p>
					
					<br/><br/>

					<?php if(!empty($order['Order']['dcountry'])) : ?>
					<h6><?php echo __('Adresse de livraison');?></h6>
					<p><?php echo __('Nom : ');?><?php echo $order['Order']['dname']; ?>
					<br/>
					<?php echo __('Prénom : ');?><?php echo $order['Order']['dfirstname']; ?>
					<br/>
					<?php echo __('Rue : ');?><?php echo $order['Order']['dstreet']; ?>
					<br/>
					<?php echo __('Code Postal : ');?><?php echo $order['Order']['dzipcode']; ?>
					<br/>
					<?php echo __('Ville : ');?><?php echo $order['Order']['dcity']; ?>
					<br/>
					<?php echo __('Pays : ');?><?php echo $order['Order']['dcountry']; ?>
					<br/>
					<?php echo __('Téléphone : ');?><?php echo $order['Order']['dphone']; ?>
					</p>
					<?php endif ?>
					
					<br/><br/>

					<h6><?php echo __('Votre commande');?></h6>
					<table>
					    <tr>
					        <th><?php echo __('Nom du produit');?></th>
					        <th></th>
					        <th><?php echo __('Prix HT en euros');?></th>
					        <th><?php echo __('Prix TTC en euros');?></th>
					      				        
					    </tr>

    				<?php $totalPrice = 0; $i=0 ; $totalTVA = 0 ; 
    				if(!empty($order['Order']['livraison'])){$delivery=$order['Order']['livraison'];}else{$delivery=0;}?>

    				<?php foreach ($cart as $key => $product): ?>
    				<!-- Creation de liste des produits dans une variable -->
	    				<?php $listproducts= $listproducts."&". $product['Product']['name']; ?>
	    				<?php $listprices= $listprices."&". $product['Product']['price'].'€'; ?>
    				
    				<!-- Lignes du tableau -->	
					    <tr>
					        <td style="text-align:left;">
					            <?php 
					              echo $this->Html->link($product['Product']['name'], array('action'=> 'view', $product['Product']['id'])); 
					             echo $this->Form->input('Product.'.$i.'.productid',array('type' => 'hidden', 'value' => $product['Product']['name'])); 
					            ?>
					        </td>
					        <td style="text-align:center;">
						       	<?php
				                    if(!empty($product['defunt_id'])){
				                        echo $this->Html->image('medias/defunts/defunt_'.$product['defunt_id'].'/tmp/toprint&'.$product['defunt_id'].'.jpg');
				                    }
				                ?>
					        </td>
					        <td style="text-align:center;">
					           <?php 
					            	echo number_format($product['Product']['price'], '2', ',',' '); 
					           ?>
					        </td>
					        <td style="text-align:center;">
			                  <?php 
			                    $tva = 1 +$product['Product']['tva'];
			                    $tvas = $product['Product']['price']*$product['Product']['tva'];
			                    $pricetva = $product['Product']['price']*$tva;
			                      echo number_format($pricetva, '2', ',',' '); 
			                  ?>
			                </td>
					    </tr>
						
						<?php 
					    	$totalPrice = $totalPrice + $product['Product']['price'];
					    	$totalTVA = $totalTVA + $tvas;
						?>

					    <?php $i=$i + 1; ?>

					<?php endforeach; ?>

						<tr>
						    <td colspan="4">&nbsp;</td>
						</tr>
						<tr>
					        <td colspan="4" style="text-align:right;"><?php echo __('Prix Total HT en euros : ');?>
					       <?php 
					           echo number_format($totalPrice, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('ht',array('type' => 'hidden', 'value' => $totalPrice)); ?>
					        </td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;"><?php echo __('TVA en euros : ');?>
					        <?php 		          
					           echo number_format($totalTVA, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('tva',array('type' => 'hidden', 'value' => $totalTVA)); ?>
					        </td>
					    </tr>
					    <tr>
					    <?php if (!empty($delivery)) : ?>
					        <td colspan="4" style="text-align:right;"><?php echo __('Livraison en euros : ');?>
					        <?php echo number_format($delivery, '2', ',',' '); ?>
					        <?php echo $this->Form->input('livraison',array('type' => 'hidden', 'value' => $delivery)); ?>
					        </td>
					    <?php else: ?>
					    	<td colspan="4" style="text-align:right;">
					    		&nbsp;
					        </td>
						<?php endif ?>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;"><?php echo __('Prix TTC en euros : ');?>
					        <?php 
					 
					          $ttc = $totalPrice+$totalTVA+$delivery;
					           echo number_format($ttc, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('ttc',array('type' => 'hidden', 'value' => $ttc)); ?>
					           
					        </td>
					    </tr>
					</table>

					<br/><br/> 

					<?php
						echo $this->Form->input('listproduct',array('type' => 'hidden', 'value' => $listproducts)); 
						echo $this->Form->input('listprice',array('type' => 'hidden', 'value' => $listprices));
					?>
			        
			        <br/>

					<?php
					 echo $this->Form->input('accord',array(
					 'type'=>'checkbox', 
					 'label'=>
					 __('Je confirme avoir lu les ').
					 $this->Html->link(__('CGV'), array('controller' => 'pages', 'action' => 'display','cgv')).
					 __(' et les ').
					 $this->Html->link(__('CGU'), array('controller' => 'pages', 'action' => 'display','cgu')), 
					 'value' => '1'
					 )); 
					 ?>
					<br/>

					<?php		
						 echo $this->Form->submit(__('Valider la commande et procéder au paiement'),array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();

						 ?>


		<?php else: ?>
			<!-- Le panier est vide -->
			<h2><?php echo __('Votre panier est vide');?></h2>
		<?php endif ?>
      </div>
    </div>
</div>