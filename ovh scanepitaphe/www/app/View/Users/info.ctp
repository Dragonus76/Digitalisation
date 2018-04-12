<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Gestion de votre compte');?></h3>
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
      <div class="small-12 medium-12 large-12 tdb lignetop">
        <?php
            echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-edit"></i><p>'.__('Mes coordonnées').'</p></div>',array('controller'=>'users','action'=>'edit'),array(
                    'escapeTitle' => false, 'title' => __('modifier vos coordonnées')
                  ));

            echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-shopping-cart"></i><p>'.__('Mes commandes').'</p></div>',array('controller'=>'orders','action'=>'myorder'),array(
                    'escapeTitle' => false, 'title' => __('voir vos commandes')
                  ));

            echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-trash"></i><p>'.__('Supprimer mon compte').'</p></div>',array('controller'=>'users','action'=>'delete'),array(
                    'escapeTitle' => false, 'title' => __('supprimer votre compte')
                  ));

                   
                    ?>

      </div>
    </div>
</div>