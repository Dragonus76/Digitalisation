<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Modification des informations de');?> <?php echo $personne['Defunt']['firstname'].' '. $personne['Defunt']['name']; ?></h3>
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
                    echo '<p>'.__('Vous n\'avez pas créé de famille.').' '.$this->Html->link(__('Créer une famille'),array('controller'=>'families','action'=>'add'));
                }
                echo $this->Form->input('title', array('label' => __('Titre (Monsieur, Madame, Famille, etc.)')));
                echo $this->Form->input('firstname', array('label' => __('Prénom')));
                echo $this->Form->input('name', array('label' => __('Nom')));    
                echo $this->Form->input('birthdate', array(
                                        'label' => __('Date de naissance'),
                                        'dateFormat' => 'DMY',
                                        'minYear' => date('Y') - 2000,
                                        'maxYear' => date('Y'),
                                 'separator' =>'',
                                        'empty'=>true
    ));                       
                echo $this->Form->input('deathdate', array(
                                        'label' => __('Date de décès'),
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
                            'alt' =>__('photo de profil de ').$personne['Defunt']['firstname'].' '.$personne['Defunt']['name'], 
                            'border' => '0',
                            'width'=>'300px',
                            'height' => '300px')); 
                }
                echo $this->Form->input('avatar_url',array('label' => __('Photo de profil'), 'type' => 'file'));
                echo $this->Form->input('lieu', array('label' => __('Lieu sépulture')));
                echo $this->Form->input('intro', array('label' => __('Courte épitaphe'),'rows'=>3)); 
            ?>
        </div>
    </div>
    <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                 <?php
                    echo $this->Form->submit(__('Enregistrer'),array('class'=>'buttonvioletokfull postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
    </div>
</div>


        
