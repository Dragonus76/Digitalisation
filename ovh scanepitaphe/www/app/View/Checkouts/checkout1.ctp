<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Vos coordonnées pour la commande');?></h3>
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
			

					<?php 
					echo $this->Form->create('Order',array('type' => 'file')); ?>
					<h6><?php echo __('Vérifiez vos coordonnées');?></h6>
					<p><?php echo __('Nom : ');?><?php echo $user['User']['name']; ?>
					<?php echo $this->Form->input('uname',array('type' => 'hidden', 'value' => $user['User']['name'])); ?>
					<br/>
					<?php echo __('Prénom : ');?><?php echo $user['User']['firstname']; ?>
					<?php echo $this->Form->input('ufirstname',array('type' => 'hidden', 'value' => $user['User']['firstname'])); ?>
					<br/>
					<?php echo __('Rue : ');?><?php echo $user['User']['street']; ?>
					<?php echo $this->Form->input('ustreet',array('type' => 'hidden', 'value' => $user['User']['street'])); ?>
					<br/>
					<?php echo __('Code Postal : ');?><?php echo $user['User']['zip_code']; ?>
					<?php echo $this->Form->input('uzipcode',array('type' => 'hidden', 'value' => $user['User']['zip_code'])); ?>
					<br/>
					<?php echo __('Ville : ');?><?php echo $user['User']['city']; ?>
					<?php echo $this->Form->input('ucity',array('type' => 'hidden', 'value' => $user['User']['city'])); ?>
					<br/>
					<?php echo __('Pays : ');?><?php echo $user['User']['country']; ?>
					<?php echo $this->Form->input('ucountry',array('type' => 'hidden', 'value' => $user['User']['country'])); ?>
					<br/>
					<?php echo __('Téléphone : ');?><?php echo $user['User']['phone']; ?>
					<?php echo $this->Form->input('uphone',array('type' => 'hidden', 'value' => $user['User']['phone'])); ?>
					<br/>
					<?php echo __('Email : ');?><?php echo $user['User']['email']; ?>
					<?php echo $this->Form->input('uemail',array('type' => 'hidden', 'value' => $user['User']['email'])); ?>
					</p>
					<?php 
						echo $this->Html->link(
						__('Modifier vos coordonnées'),
						array('controller'=>'users','action'=>'edit'));
					?>



					<br/><br/>

					
					<?php
					$type =0; 
    				foreach ($cart as $key => $product){
    					if($product['Product']['type'] == 1){
	    						$type=1;
	    					}
    				}
    				if ($type == 1){
						 
						echo '<h6>'.__('Adresse de livraison').'</h6>';

						echo $this->Form->input('dname',array('label' => __('Nom')));
						echo $this->Form->input('dfirstname',array('label' => __('Prénom')));
						echo $this->Form->input('dstreet',array('label' => __('Rue')));
						echo $this->Form->input('dzipcode',array('label' => __('Code Postal')));
						echo $this->Form->input('dcity',array('label' => __('Ville'))); 
						echo $this->Form->input('dcountry',array('label' => __('Pays'),'options' => $pays)); 
						echo $this->Form->input('dphone',array('label' => __('Téléphone'))); 

						echo '<br/><br/>';

						echo $this->Form->input('livraison', array(
                              	'type'=>'select',
                              'label' => __('Choisir un tarif de livraison'))); 
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
					      
						<?php
		
						 echo $this->Form->submit(__('Valider vos coordonnées et passer à l\'étape suivante'),array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();

						 ?>


		<?php else: ?>
			<!-- Le panier est vide -->
			<h2><?php echo __('Votre panier est vide');?></h2>
		<?php endif ?>
      </div>
    </div>
</div>