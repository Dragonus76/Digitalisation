<div class="row">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
			<h2 class="robotobold">Rappel du mot de passe</h2>
		        <?php 
		        	echo $this->Form->create('User'); 
		            echo $this->Form->input('email',array('label' => 'Email','placeholder'=>'votre email')); 
		            echo $this->Form->submit('Regénérer mon mot de passe',array('class'=>'button postfix')); 
    				echo $this->Form->end();
				?>
		        
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>