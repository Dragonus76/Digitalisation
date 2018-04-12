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
            <h3>Mon panier</h3>
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
        <?php if(!$cart): ?>
          <p>Votre panier est vide. Rendez vous dans la <?php echo $this->Html->link('boutique',array('controller'=>'products','action'=>'scanshop'));?></p>
        <?php else: ?>
          <table>
              <tr>
                  <th>Nom du produit</th>
                  <th>&nbsp;</th>
                  <th>Prix HT en euros</th>
                  <th>Prix TTC en euros</th>
                  <th></th>
              </tr>
              <?php $totalPrice = 0; ?>
         
              <?php foreach ($cart as $key => $product): ?>
              <tr>
                  <td>
                  <?php 
                    echo $this->Html->link($product['Product']['name'], array('controller'=>'products', 'action'=> 'view', $product['Product']['id'])); 
                  ?>
                  </td>
                  <td>
                  <?php
                      if(!empty($product['defunt_id'])) : ?>
                          <a href="#" data-reveal-id="myModal" title="cliquez pour prévisualiser"><?php echo $this->Html->image('medias/defunts/defunt_'.$product['defunt_id'].'/tmp/toprint&'.$product['defunt_id'].'.jpg'); ?></a>
                          <div id="myModal" class="reveal-modal" data-reveal>
  <h2>Prévisualisation de votre plaque</h2>
  <?php echo $this->Html->image('medias/defunts/defunt_'.$product['defunt_id'].'/tmp/toprint&'.$product['defunt_id'].'.jpg'); ?>
  <a class="close-reveal-modal">&#215;</a>
</div>

                      <?php endif ?>

                      


                  </td>
        
                  <td style="text-align:center;">
                  <?php 
                    echo number_format($product['Product']['price'], '2', ',',' '); 
                  ?>
                  </td>
                  <td style="text-align:center;">
                  <?php 
                    $tva = $tva = 1 +$product['Product']['tva'];
                      echo number_format($product['Product']['price']*$tva, '2', ',',' '); 
                  ?>
                  </td>
                  <td style="text-align:center;">
                  <?php 
                        echo $this->Html->link('Supprimer', array('controller'=>'checkouts','action' => 'delete_cart',$key)); 
                  ?>
                  </td>
              </tr>
                  <?php 
                    $totalPrice = $totalPrice + $product['Product']['price']*$tva; 
                  ?>           
          <?php endforeach; ?>
              <tr>
                <td colspan="4" style="text-align:right;">
                  <?php 
                    echo 'Prix total TTC : '.$totalPrice.' euros'; 
                  ?>
                </td>
                <td>&nbsp;</td>
              </tr>
          </table>
          <?php
            echo $this->Html->link('Vider le panier', array('controller'=>'checkouts','action'=>'empty_cart'));
          ?>
          <br/><br/>
          <?php 
                //lien vers la page des produits
                echo $this->Html->link('Procéder au paiement', array('controller' => 'checkouts', 'action' => 'checkout1'),array('class'=>'buttonvioletokfull postfix')); 
              ?>
              <?php echo $this->Html->link('Retour à la boutique',array('controller'=>'products','action'=>'scanshop'));?>
        <?php endif ?>
      </div>
    </div>
</div>