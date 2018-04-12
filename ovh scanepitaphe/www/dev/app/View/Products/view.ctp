<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo $product['Product']['name']; ?></h3>
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
      	<div class="center">
			<?php
				echo $this->Html->image('products/'.$product['Product']['thumbnail'], array('alt' => $product['Product']['name'], 'height' => 250)); 
			?>
		</div>
		<h6>Description</h6>
		<p><?php echo $product['Product']['content']; ?></p>
		<br/>
		<h6>Prix</h6>
		<?php $tva = 1 +$product['Product']['tva'];?>

		<p>Prix TTC: <?php echo $product['Product']['price']*$tva.'€'; ?></p>
		<?php if($product['Product']['nupload'] == 1):?>
			<?php
				echo $this->Form->create('Checkout', array('action' => 'custom/'.$product['Product']['id'],'type'=>'file'));
				foreach ($personnes as $key => $value) {
                    $k=$value['Defunt']['id'];
                    $array[$k]=$value['Defunt']['firstname'].' '.$value['Defunt']['name'];
                }
            
		        if(!empty($array)){echo $this->Form->input('defunt_id', array(
		                      'label' => '1- Choississez la personne concernée par l\'ajout',
		                      'options' => $array,
		                      'empty'=>'Choisissez une personne'));
		        }else{
		        	echo '<p>Vous devez ajouter une personne pour commencer.</p>';
		        }

				echo $this->Form->input('content', array('label' => '2 - Ajouter un texte à imprimer sur la plaque','rows' => '3'));
				echo $this->Form->input('picture_file',array('label' => '3 - Choisissez votre photo personnelle (mode portrait(', 'type' => 'file')); 
				echo $this->Form->input('prodname',array('type'=>'hidden','value'=>$product['Product']['name']));
				echo $this->Form->submit('Personnaliser l\'apparence',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
            ?>
			
		<?php else: ?>
		<br/>
			<?php echo $this->Html->link('Ajouter au panier', array('controller'=>'checkouts', 'action' => 'add_to_cart',  $product['Product']['id']),array('class' => 'buttonvioletokfull')); ?>
		<?php endif ?>
      </div>
    </div>
</div>

