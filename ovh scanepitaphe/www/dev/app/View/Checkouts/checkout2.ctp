<script type="text/javascript"> 
<!-- 
function BoutonDroit() 
{ 
if((event.button==2)||(event.button==3)||(event.button==4)) 
alert('Le bouton droit de la souris à été desactivé'); 
} 
document.onmousedown=BoutonDroit; 

//--> 
</script>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Récapitulatif de votre commande</h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
      	<?php if ($this->Session->read('Cart')): ?>
			

					<?php echo $this->Form->create('Order'); ?>
					<h6>Vos coordonnées</h6>
					<p>Nom : <?php echo $order['Order']['uname']; ?>
					<br/>
					Prénom : <?php echo $order['Order']['ufirstname']; ?>
					<br/>
					Rue : <?php echo $order['Order']['ustreet']; ?>
					<br/>
					Code Postal : <?php echo $order['Order']['uzipcode']; ?>
					<br/>
					Ville : <?php echo $order['Order']['ucity']; ?>
					<br/>
					Pays : <?php echo $order['Order']['ucountry']; ?>
					<br/>
					Téléphone : <?php echo $order['Order']['uphone']; ?>
					<br/>
					Email : <?php echo $order['Order']['uemail']; ?>
					</p>
					
					<br/><br/>

					<?php if(!empty($order['Order']['dcountry'])) : ?>
					<h6>Adresse de livraison</h6>
					<p>Nom : <?php echo $order['Order']['dname']; ?>
					<br/>
					Prénom : <?php echo $order['Order']['dfirstname']; ?>
					<br/>
					Rue : <?php echo $order['Order']['dstreet']; ?>
					<br/>
					Code Postal : <?php echo $order['Order']['dzipcode']; ?>
					<br/>
					Ville : <?php echo $order['Order']['dcity']; ?>
					<br/>
					Pays : <?php echo $order['Order']['dcountry']; ?>
					<br/>
					Téléphone : <?php echo $order['Order']['dphone']; ?>
					</p>
					<?php endif ?>
					
					<br/><br/>

					<h6>Votre commande</h6>
					<table>
					    <tr>
					        <th>Nom du produit</th>
					        <th></th>
					        <th>Prix HT en euros</th>
					        <th>Prix TTC en euros</th>
					      				        
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
					        <td colspan="4" style="text-align:right;">Prix Total HT en euros :
					       <?php 
					           echo number_format($totalPrice, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('ht',array('type' => 'hidden', 'value' => $totalPrice)); ?>
					        </td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;">TVA en euros : 
					        <?php 		          
					           echo number_format($totalTVA, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('tva',array('type' => 'hidden', 'value' => $totalTVA)); ?>
					        </td>
					    </tr>
					    <tr>
					    <?php if (!empty($delivery)) : ?>
					        <td colspan="4" style="text-align:right;">Livraison en euros : 
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
					        <td colspan="4" style="text-align:right;">Prix TTC en euros : 
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
					 echo $this->Form->input('accord',array('type'=>'checkbox', 'label'=>__('Je confirme avoir lu les '. $this->Html->link('CGV', array('controller' => 'pages', 'action' => 'display','cgv')) . ' et les ' . $this->Html->link('CGU', array('controller' => 'pages', 'action' => 'display','cgu')), true), 'value' => '1')); ?>
					<br/>

					<?php		
						 echo $this->Form->submit('Valider la commande et procéder au paiement',array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();

						 ?>


		<?php else: ?>
			<!-- Le panier est vide -->
			<h2>Votre panier est vide</h2>
		<?php endif ?>
      </div>
    </div>
</div>