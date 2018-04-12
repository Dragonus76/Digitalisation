<?php if(empty($cats)) : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Liste des catégories pour');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('éditer les informations de cette personne')
                  ));?></h3>
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
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-tag"></i><p>'.__('Créer une catégorie').'</p></div>',array('controller'=>'categories','action'=>'add',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('créer une catégorie')
                  ));
                ?> 
      </div>
    </div>
</div>
<?php else : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Liste des catégories pour');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('modifier les informations de cette personne')
                  ));?></h3>
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
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-tag"></i><p>'.__('Créer une catégorie').'</p></div>',array('controller'=>'categories','action'=>'add',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('créer une catégorie')
                  ));
                ?>
        <?php
                foreach ($cats as $key => $value) {
                    echo '<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe" style="padding:0;">';
                   echo '<p class="top">'.$value['Category']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link(__('Modifier'),array('controller'=>'categories','action'=>'edit',$value['Category']['id'])).' - '.$this->Html->link(__('Supprimer cette catégorie'),array('controller'=>'categories','action'=>'delete',$value['Category']['id']),null,__('Voulez vous vraiment supprimer cette catégorie ? Cette action est DEFINITIVE.'));
                    echo '</p></div>'; 
                    
                }
            ?>
      </div>
  </div>
  
</div>
<?php endif ?>          