<div class="row minha">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
		<?php if (!empty($this->request->data)): ?>
		<?php else: ?>
			<h2 class="robotobold"><?php echo __('Se connecter');?></h2>
		        <?php 
		        	echo $this->Form->create('User'); 
		            echo $this->Form->input('username', array('label' => __('Nom d\'utilisateur'),'placeholder'=>__('votre nom d\'utilisateur'))); 
		            echo $this->Form->input('password', array('label' => __('Mot de passe'),'placeholder'=>__('votre mot de passe'))); 
		            echo $this->Form->submit(__('Continuer'),array('class'=>'buttonvioletokfull postfix')); 
    				echo $this->Form->end();
				?>
		        <p><em><?= $this->Html->link(__('Mot de passe oublié ? Nom d\'utilisateur oublié ?'), array('action' => 'forgot')); ?></em><br/> <em><?= $this->Html->link(__('S\'inscrire gratuitement'), array('action' => 'register')); ?></em></p>
		 <?php endif ?>
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>