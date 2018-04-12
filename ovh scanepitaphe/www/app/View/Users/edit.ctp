<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Modifier mes coordonnées');?></h3>
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
				echo $this->Form->create('User',array('type' => 'file'));
                echo $this->Form->input('email',array('label' => __('Votre adresse email'),'placeholder'=>__('votre email')));
				echo $this->Form->input('firstname',array('label' => __('Prénom'),'placeholder'=>__('votre prénom')));
				echo $this->Form->input('name',array('label' => __('Nom'),'placeholder'=>__('votre nom')));
				echo $this->Form->input('phone',array('label' => __('Téléphone (attention requis si vous faites une commande via la boutique)'),'placeholder'=>__('votre téléphone')));
                echo $this->Form->input('birthdate', array(
                                            'label' => __('Date de naissance'),
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'placeholder'=>'votre date de naissance',
                                            'separator'=>'',
                                            'empty'=>true
                    ));
                echo $this->Form->input('street',array('label' => __('Rue'),'placeholder'=>__('votre rue')));
				echo $this->Form->input('zip_code',array('label' => __('Code postal'),'placeholder'=>__('votre code postal')));
				echo $this->Form->input('city',array('label' => __('Ville'),'placeholder'=>__('votre ville')));
				echo $this->Form->input('country',array('label' => __('Pays'),'placeholder'=>__('votre pays')));
                ?>
		</div>
        <div class="small-12 medium-7 large-7 columns">
            <?php
            if(!empty($user['User']['avatar'])){
                    echo $this->Html->image('medias'. DS .'users'. DS .'user_'.$user['User']['id'] . DS .$user['User']['avatar'], 
                        array(
                            'alt' =>__('photo de profil de ').$user['User']['firstname'].' '.$user['User']['name'], 
                            'border' => '0',
                            'width'=>'300',
                            'height' => '300')); 
                }
                echo $this->Form->input('avatar_url',array('label' => __('Photo de profil'), 'type' => 'file'));
				echo $this->Form->submit(__('Modifier'),array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();
			?>

      </div>
    </div>
</div>