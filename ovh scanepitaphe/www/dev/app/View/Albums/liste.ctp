<?php if(empty($albs)) : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Liste des albums pour <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'éditer les informations de cette personne'
                  ));?></h3>
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
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-files-o"></i><p>Ajouter un album</p></div>',array('controller'=>'albums','action'=>'add',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'créer une catégorie'
                  ));
                ?> 
      </div>
    </div>
</div>
<?php else : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Liste des albums pour <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'modifier les informations de cette personne'
                  ));?></h3>
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
            
                <?php
                    echo $this->Html->link('<div class="small-12 medium-3b large-3b columns center bgviolet left heightfixe"><i class="fa fa-files-o"></i><p>Ajouter un album</p></div>',array('controller'=>'albums','action'=>'add',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'créer un album'
                  ));
                ?> 
        <?php
            foreach ($albs as $key => $value) {
             $img = $this->requestAction('media/getbyimage/'.$value['Album']['id']);
          
              if(!empty($personne['Defunt']['avatar'])){
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe " style="position: relative;background:url(http://scanepitaphe.fr/img/medias/defunts/'.'defunt_'.$personne['Defunt']['id'].'/'.$img['Media']['nomfichier'].')no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">'; 
                    }else{
                        echo '<div class="small-12 medium-3b large-3b center left heightfixe" style="position: relative;background:url(http://scanepitaphe.fr/img/fond-gris.jpg)no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">';                   
                    }

                    echo '<p class="top">'.$value['Album']['name'].'</p>';
                    echo '<p class="bottom">'.$this->Html->link('Modifier',array('controller'=>'albums','action'=>'edit',$value['Album']['id'])).' - '.$this->Html->link('Ajouter une image dans cet album',array('controller'=>'media','action'=>'addimagealb',$personne['Defunt']['id'],$value['Album']['id'])).' - '.$this->Html->link("Supprimer cet album",array('controller'=>'albums','action'=>'delete',$value['Album']['id'],null,'Voulez vous vraiment supprimer cet album ? Cette action est DEFINITIVE.'));
                    echo '</p></div>';
                }
            ?>        
      </div>
  </div>

</div>
<?php endif ?>          