<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Paramètres de la page de <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
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
      <div class="small-12 medium-12 large-12 columns">
        <p> <?php echo $this->Html->link('Restreindre l\'accès / Changer le mot passe d\'accès à la page',array('controller'=>'clientpages','action'=>'editpass',$clientpage['ClientPage']['id'])); ?></p>

                <p> Image de fond - <?php echo $this->Html->link('Changer l\'image de fond de la page',array('controller'=>'clientpages','action'=>'backgroundimg',$clientpage['ClientPage']['id']),array(
                    'escapeTitle' => false, 'title' => 'changer l\'image de fond de cette page'
                  ));?></p>
                <?php
                    if(!empty($clientpage['ClientPage']['backgroundimg'])){
                         echo $this->Html->image('medias/defunts/'.'defunt_'.$clientpage['ClientPage']['defunt_id'].'/'.$clientpage['ClientPage']['backgroundimg'], 
              array(
                'alt' => 'image de fond',
                'width'=>'317',
                'height'=>'210'
                ));
                        }else{
                            echo $this->Html->Image('http://placehold.it/317x210'); 
                            }
                ?>
                
      </div>
    </div>
</div>