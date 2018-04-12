<div class="row minha">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
		<?php if (!empty($this->request->data)): ?>
		<?php else: ?>
			<h2 class="robotobold">Se connecter</h2>
		        <?php 
		        	echo $this->Form->create('User'); 
		            echo $this->Form->input('username', array('label' => "Nom d'utilisateur",'placeholder'=>'votre nom d\'utilisateur')); 
		            echo $this->Form->input('password', array('label' => "Mot de passe",'placeholder'=>'votre mot de passe')); 
		            echo $this->Form->submit('Continuer',array('class'=>'buttonvioletokfull postfix')); 
    				echo $this->Form->end();
				?>
		        <p><em><?= $this->Html->link('Mot de passe oublié ?', array('action' => 'forgot')); ?></em><br/> <em><?= $this->Html->link('S\'inscrire gratuitement', array('action' => 'register')); ?></em></p>
		 <?php endif ?>
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>