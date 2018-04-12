<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Modification des informations de <?php echo $personne['Defunt']['firstname'].' '. $personne['Defunt']['name']; ?></h3>
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
         <div class="small-12 medium-5 large-5 columns">
            <?php
                echo $this->Form->create('Defunt',array('type' => 'file'));
                echo $this->Form->input('client_page_id', array('type' => 'hidden', 'value' => $personne['Defunt']['client_page_id'])); 
                foreach ($families as $key => $value) {
                    $k=$value['Family']['id'];
                    $array[$k]=$value['Family']['name'];
                }
                if(!empty($array)){echo $this->Form->input('family_id', array(
                      'label' => 'Famille',
                      'options' => $array));
                }else{
                    echo '<p>Vous n\'avez pas créé de famille. '.$this->Html->link('Créer une famille',array('controller'=>'families','action'=>'add'));
                }
                echo $this->Form->input('title', array('label' => 'Titre (Monsieur, Madame, Famille, etc.)'));
                echo $this->Form->input('firstname', array('label' => 'Prénom'));
                echo $this->Form->input('name', array('label' => 'Nom'));    
                echo $this->Form->input('birthdate', array(
                                        'label' => 'Date de naissance',
                                        'dateFormat' => 'DMY',
                                        'minYear' => date('Y') - 2000,
                                        'maxYear' => date('Y'),
                                 'separator' =>'',
                                        'empty'=>true
    ));                       
                echo $this->Form->input('deathdate', array(
                                        'label' => 'Date de décès',
                                        'dateFormat' => 'DMY',
                                        'minYear' => date('Y') - 2000,
                                        'maxYear' => date('Y'),
                                        'separator' =>'',
                                        'empty'=>true
    ));
            ?>
        </div>
        <div class="small-12 medium-7 large-7 columns">
            <?php
                if(!empty($personne['Defunt']['avatar'])){
                    echo $this->Html->image('medias'. DS .'defunts'. DS .'defunt_'.$personne['Defunt']['id'] . DS .$personne['Defunt']['avatar'], 
                        array(
                            'alt' =>'photo de profil de '.$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'], 
                            'border' => '0',
                            'width'=>'300px',
                            'height' => '300px')); 
                }
                echo $this->Form->input('avatar_url',array('label' => 'Photo de profil', 'type' => 'file'));
                echo $this->Form->input('lieu', array('label' => 'Lieu sépulture'));
                echo $this->Form->input('intro', array('label' => 'Courte épitaphe','rows'=>3)); 
            ?>
        </div>
    </div>
    <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                 <?php
                    echo $this->Form->submit('Enregistrer',array('class'=>'buttonvioletokfull postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
    </div>
</div>


        
