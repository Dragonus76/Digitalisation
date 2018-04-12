<div class="row">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
			<h2 class="robotobold">Modifier votre mot de passe</h2>
		        <?php 
		        	echo $this->Form->create('User'); 
		        	echo $this->Form->input('password', array('label' => "Mot de passe",'placeholder'=>'votre mot de passe'));
		        	echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => "Confirmer Mot de passe",'placeholder'=>'confirmer votre mot de passe'));
		            echo $this->Form->submit('Enregistrer votre nouveau mon mot de passe',array('class'=>'buttonvioletokfull postfix')); 
    				echo $this->Form->end();
				?>
		        
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>