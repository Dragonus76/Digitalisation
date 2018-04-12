<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Boutique</h3>
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
      <div class="small-12 medium-12 large-12 tdb lignetop">
      	<p class="footgrey justify">
                Bienvenue dans la boutique!<br/>
                La boutique vous propose un ensemble de produits pour améliorer votre expérience Scanepitaphe. Des extensions pour ajouter davantage de contenus. D'autres produits comme nos plaques commémoratives qui peuvent servir d'ornements sur une stèle et permettent un accès à une page individuelle avec un QR code.
            </p>
    	<?php if(empty($products)) :?>
    		<p>La boutique est vide.</p>
    	<?php else: ?>
			

            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-shopping-cart"></i><p>Mon panier</p></div>',array('controller'=>'checkouts','action'=>'cart'),array(
                    'escapeTitle' => false, 'title' => 'créer un album'
                  ));
                ?> 

				<?php foreach ($products as $product): ?>
				<?php 
                if($product['Product']['type'] == 1){
                echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/products/'.$product['Product']['thumbnail'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';
                echo '<p class="top" style="background-color:rgba(153,51,102,1);">'.$product['Product']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link('Voir',array('controller'=>'products','action'=>'view',$product['Product']['id']));
                    echo '</p></div>'; 
                }else{
                    echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/products/'.$product['Product']['thumbnail'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';
                echo '<p class="top" style="background-color:rgba(153,51,102,1);">'.$product['Product']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link('Ajouter au panier', array('controller'=>'checkouts', 'action' => 'add_to_cart',  $product['Product']['id']));
                    echo '</p></div>'; 
                }
                    ?>
				<?php endforeach; ?>
				<?php unset($post); ?>
				
			
	<?php endif ?>
      </div>
    </div>
</div>