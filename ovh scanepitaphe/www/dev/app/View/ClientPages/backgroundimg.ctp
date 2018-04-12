<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Choix de l'image de fond pour la page de <?php echo $this->Html->link($clientpage['Defunt']['firstname'].' '.$clientpage['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$clientpage['Defunt']['id']),array(
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
         <?php
            echo $this->Form->create('ClientPage',array('type' => 'file'));
            echo $this->Form->input('client_page_id', array('type' => 'hidden', 'value' => $clientpage['ClientPage']['id'])); 
            echo $this->Form->input('backgroundimg',array('label' => 'Choississez un fichier pour l\'image de fond de page', 'type' => 'file'));
            echo $this->Form->submit('Enregistrer la nouvelle photo de fond',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>