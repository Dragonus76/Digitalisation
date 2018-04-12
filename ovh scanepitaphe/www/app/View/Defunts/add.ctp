<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Ajouter une personne ou un groupe de personnes à la famille');?> <?php echo $famille['Family']['name']; ?></h3>
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
            <div class="small-12 medium-6 large-6 columns">
                <?php
                 echo $this->Form->create('Defunt',array('type' => 'file'));
             echo $this->Form->input('family_id', array('type' => 'hidden', 'value' => $id));
             echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id'])); 
            echo $this->Form->input('title', array('label' => __('Titre (Monsieur, Madame, Famille, etc.)')));
            echo $this->Form->input('firstname', array('label' => __('Prénom')));
            echo $this->Form->input('name', array('label' => __('Nom')));
            echo $this->Form->input('birthdate', array(
                                            'label' => __('Date de naissance'),
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator'=>'',
                                            'empty'=>true
                    ));
            echo $this->Form->input('deathdate', array(
                                            'label' => __('Date de décès'),
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator'=>'',
                                            'empty'=>true
                    ));
            
                ?>
            </div>
            <div class="small-12 medium-6 large-6 columns">
                <?php
                    echo $this->Form->input('avatar_url',array('label' => __('Photo de profil'), 'type' => 'file'));
                    echo $this->Form->input('lieu', array('label' => __('Lieu sépulture')));
                    echo $this->Form->input('intro', array('label' => __('Courte épitaphe'),'rows'=>3));
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                 <?php
                    echo $this->Form->submit(__('Ajouter'),array('class'=>'buttonvioletokfull postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
        </div>
</div>