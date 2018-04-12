<div class="row minha">
  <?php echo $this->element('bord'); ?>
    <div class="small-12 medium-8 large-8 columns nopuce">
    	<h4>Récapitulatif de votre commande</h4><!-- Test si le panier n'est pas vide -->
		<?php if ($this->Session->read('Cart')): ?>
			

					<?php echo $this->Form->create('Order',array('type' => 'file')); ?>
					<h6>Vos coordonnées</h6>
					<p>Nom : <?php echo $user['User']['name']; ?>
					<?php echo $this->Form->input('uname',array('type' => 'hidden', 'value' => $user['User']['name'])); ?>
					<br/>
					Prénom : <?php echo $user['User']['firstname']; ?>
					<?php echo $this->Form->input('ufirstname',array('type' => 'hidden', 'value' => $user['User']['firstname'])); ?>
					<br/>
					Rue : <?php echo $user['User']['street']; ?>
					<?php echo $this->Form->input('ustreet',array('type' => 'hidden', 'value' => $user['User']['street'])); ?>
					<br/>
					Code Postal : <?php echo $user['User']['zip_code']; ?>
					<?php echo $this->Form->input('uzipcode',array('type' => 'hidden', 'value' => $user['User']['zip_code'])); ?>
					<br/>
					Ville : <?php echo $user['User']['city']; ?>
					<?php echo $this->Form->input('ucity',array('type' => 'hidden', 'value' => $user['User']['city'])); ?>
					<br/>
					Pays : <?php echo $user['User']['country']; ?>
					<?php echo $this->Form->input('ucountry',array('type' => 'hidden', 'value' => $user['User']['country'])); ?>
					<br/>
					Téléphone : <?php echo $user['User']['phone']; ?>
					<?php echo $this->Form->input('uphone',array('type' => 'hidden', 'value' => $user['User']['phone'])); ?>
					<br/>
					Email : <?php echo $user['User']['email']; ?>
					<?php echo $this->Form->input('uemail',array('type' => 'hidden', 'value' => $user['User']['email'])); ?>
					</p>
					<?php 
						echo $this->Html->link(
						'Modifier vos coordonnées',
						array('controller'=>'users','action'=>'edit'));
					?>



					<br/><br/>

					<h6>Adresse de livraison</h6>
					<?php
						
						 

						echo $this->Form->input('dname',array('label' => 'Nom'));
						echo $this->Form->input('dfirstname',array('label' => 'Prénom'));
						echo $this->Form->input('dstreet',array('label' => 'Rue'));
						echo $this->Form->input('dzipcode',array('label' => 'Code Postal'));
						echo $this->Form->input('dcity',array('label' => 'Ville')); 
						echo $this->Form->input('dcountry',array('label' => 'Pays','options' => $pays)); 
						echo $this->Form->input('dphone',array('label' => 'Téléphone')); ?>


						<br/><br/>



					<h6>Votre commande</h6>
					<table>
					    <tr>
					        <th>Nom du produit</th>
					        <th></th>
					        <th>Prix HT en euros</th>
					        <th>Prix TTC en euros</th>
					        <th></th>				        
					    </tr>

    				<?php $totalPrice = 0; $i=0 ; $totalTVA = 0 ; $delivery=0; $type =0; ?>


    				<?php foreach ($cart as $key => $product): ?>
    				<!-- Définition du cout de la livraison -->
	    				<?php 
	    					if($product['Product']['type'] == 1){
	    						$type=1;
	    					}
	    				?>

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
                        echo $this->Html->image('/interact/tmp/toprint&'.$product['defunt_id'].'.jpg');
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
			                
					    
					        <td style="text-align:center;">
					            <?php 
					              echo $this->Html->link('Supprimer', array('controller'=>'checkouts','action' => 'delete_cart',$key)); 
					            ?>
					        </td>
					    </tr>
					    

					<!-- calcul du prix total -->
					    <?php 
					    	$totalPrice = $totalPrice + $product['Product']['price'];
					    	$totalTVA = $totalTVA + $tvas;
						?>
					    <?php $i=$i + 1; ?>
					<?php endforeach; ?>
					<tr>
					    	<td colspan="5">&nbsp;</td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;">Prix Total HT en euros :
					       <?php 
					           echo number_format($totalPrice, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('ht',array('type' => 'hidden', 'value' => $totalPrice)); ?>
					        </td>
					        <td >&nbsp;</td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;">TVA en euros : 
					        <?php 		          
					           echo number_format($totalTVA, '2', ',',' '); 
					           ?>
					           <?php echo $this->Form->input('tva',array('type' => 'hidden', 'value' => $totalTVA)); ?>
					        </td>
					        <td>&nbsp;</td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;">Livraison en euros : 
					        <?php 
					        if ($type == 1){
					        	
					          // echo number_format($delivery, '2', ',',' '); 
					        	echo $this->Form->input('livraison', 
                              array(
                              	'type'=>'select',
                              'label' => 'Choisir un tarif')); 
					          $this->Js->get('#OrderDcountry')->event('change', 
                $this->Js->request(array('controller'=>'checkouts','action'=>'getByCountry'), 
                    array(
                    'update'=>'#OrderLivraison',
                    'async' => true,
                    'method' => 'post',
                    'dataExpression'=>true,
                    'data'=> $this->Js->serializeForm(array(
                        'isForm' => true,
                        'inline' => true
                        ))
                    ))
                );
					          }
					          



					          ?>
					        </td>
					        <td>&nbsp;</td>
					    </tr>
					    <tr>
					        <td colspan="4" style="text-align:right;">Prix TTC en euros : 
					        <?php 
					 
					          $ttc = $totalPrice+$totalTVA+$deliveryt;
					           echo number_format($ttc, '2', ',',' '); 
					           ?>
					           
					        </td>
					        <td>&nbsp;</td>
					    </tr>


					</table>



						<br/><br/> 



					

						<h6>Choix du moyen de paiement</h6>
						<p>Attention le paiement en ligne est plafonné à 250€</p>
						<?php
						echo $this->Form->input('listproduct',array('type' => 'hidden', 'value' => $listproducts)); 
						echo $this->Form->input('listprice',array('type' => 'hidden', 'value' => $listprices));
							 $pay = array('P' => 'Paiement en ligne');
							
						?>
			            <?= $this->Form->input('paiement', array(
			            	'label' => 'Moyen de paiment',
			            	'options' => $pay,
      						'empty' => '(Choisissez)')); ?>
      						<br/>
						<?php
						 echo $this->Form->input('accord',array('type'=>'checkbox', 'label'=>__('Je confirme avoir lu les '. $this->Html->link('CGV', array('controller' => 'pages', 'action' => 'display','cgv')) . ' et les ' . $this->Html->link('CGU', array('controller' => 'pages', 'action' => 'display','cgu')), true), 'value' => '1')); ?>
						<br/>
						<?php
		
						 echo $this->Form->submit('Valider la commande et procéder au paiement',array('class'=>'button postfix')); 
    			echo $this->Form->end();

						 ?>


		<?php else: ?>
			<!-- Le panier est vide -->
			<h2>Votre panier est vide</h2>
		<?php endif ?>
	</div>
</div>