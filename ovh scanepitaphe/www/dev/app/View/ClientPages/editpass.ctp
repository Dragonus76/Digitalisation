<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Choix du mot de passe pour la page de <?php echo $this->Html->link($clientpage['Defunt']['firstname'].' '.$clientpage['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$clientpage['Defunt']['id']),array(
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
        <p class="justify">Vous avez la possibilité de restreindre l'accès à vos pages aux personnes que vous souhaitez. Pour ce faire, définissez un mot de passe et cocher 'protéger ma page avec un mot de passe'. Ensuite, communiquez le mot de passe aux personnes de votre choix.
        A tout moment, vous pouvez modifier le mot de passe ou rendre la page publique en décochant 'protéger ma page avec un mot de passe'.</p>
        <?php
            echo $this->Form->create('ClientPage');
            echo $this->Form->input('client_page_id', array('type' => 'hidden', 'value' => $clientpage['ClientPage']['id'])); 
            echo $this->Form->input('password',array('label' => 'Définissez un mot de passe'));
            echo $this->Form->input('protect',array('label' => 'Protéger ma page avec un mot de passe'));
            echo $this->Form->submit('Enregistrer les modifications',array('class'=>'buttonvioletokfull postfix')); 
            echo $this->Form->end();
        ?>
      </div>
    </div>
</div>       