<div class="row">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
			<h2 class="robotobold"><?php echo __('Modifier votre mot de passe');?></h2>
		        <?php 
		        	echo $this->Form->create('User'); 
		        	echo $this->Form->input('password', array('label' => __('Renseignez votre NOUVEAU mot de passe'),'placeholder'=>__('Renseignez votre NOUVEAU mot de passe')));
		        	echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => __('Renseignez une deuxième fois votre NOUVEAU mot de passe'),'placeholder'=>__('Renseignez une deuxième fois votre NOUVEAU mot de passe')));
		            echo $this->Form->submit(__('Enregistrer votre nouveau mot de passe'),array('class'=>'buttonvioletokfull postfix')); 
    				echo $this->Form->end();
				?>
		        
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>