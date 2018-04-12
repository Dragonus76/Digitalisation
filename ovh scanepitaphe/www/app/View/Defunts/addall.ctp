<div class="row minha">
       <?php echo $this->element('bord'); ?>
    <div class="small-12 medium-8 large-8 columns">
        <h4><?php echo __('Ajouter un proche ou un groupe de proches');?></h4>
        <div class="row">
            <div class="small-12 medium-5 large-5 columns">
                <?php
            echo $this->Form->create('Defunt',array('type' => 'file'));
            foreach ($families as $key => $value) {
                    $k=$value['Family']['id'];
                    $array[$k]=$value['Family']['name'];
                }
            if(!empty($array)){
            echo $this->Form->input('family_id', array(
                      'label' => __('Choississez une famille pour ce proche'),
                      'options' => $array));}
           echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['User']['id'])); 
            echo $this->Form->input('title', array('label' => __('Titre (Monsieur, Madame, Famille, etc.)')));
            echo $this->Form->input('firstname', array('label' => __('Prénom')));
            echo $this->Form->input('name', array('label' => __('Nom')));
            echo $this->Form->input('lieu', array('label' => __('Lieu sépulture')));
            echo $this->Form->input('intro', array('label' => __('Courte épitaphe')));
                ?>
            </div>
            <div class="small-12 medium-7 large-7 columns">
                <?php
                    echo $this->Form->input('avatar_url',array('label' => __('Photo de profil'), 'type' => 'file'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-12 large-12 columns inline">
                <?php
                    echo $this->Form->input('birthdate', array(
                                            'label' => __('Date de naissance'),
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'separator' =>'',
                                            'empty'=>true
                    ));
                ?>
            </div>
            <div class="small-12 medium-12 large-12 columns inline">
                <?php
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
        </div>
        <div class="row">
            <div class="small-12 medium-12 large-12 columns">
                 <?php
                    echo $this->Form->submit(__('Ajouter ce proche'),array('class'=>'button postfix')); 
                    echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>            
