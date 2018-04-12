<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Modifier mes coordonnées</h3>
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
				echo $this->Form->create('User');
				echo $this->Form->input('firstname',array('label' => 'Prénom','placeholder'=>'votre prénom'));
				echo $this->Form->input('name',array('label' => 'Nom','placeholder'=>'votre nom'));
				echo $this->Form->input('phone',array('label' => 'Téléphone (si vous faites une commande via le Scanshop)','placeholder'=>'votre téléphone'));
                echo $this->Form->input('birthdate', array(
                                            'label' => 'Date de naissance',
                                            'dateFormat' => 'DMY',
                                            'minYear' => date('Y') - 2000,
                                            'maxYear' => date('Y'),
                                            'placeholder'=>'votre date de naissance',
                                            'separator'=>'',
                                            'empty'=>true
                    ));
                echo $this->Form->input('street',array('label' => 'Rue','placeholder'=>'votre rue'));
				echo $this->Form->input('zip_code',array('label' => 'Code postal','placeholder'=>'votre code postal'));
				echo $this->Form->input('city',array('label' => 'Ville','placeholder'=>'votre ville'));
				echo $this->Form->input('country',array('label' => 'Pays','placeholder'=>'votre pays'));
				
				echo $this->Form->submit('Modifier',array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();
			?>
      </div>
    </div>
</div>