<div class="row">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
		<h2 class="robotobold"><?php echo __('Inscription');?></h2>
		<p class="grey"><?php echo __('Ecrivez vos mémoires ou celles de vos proches. Partagez vos souvenirs');?></p>
		<p class="grey">
			<small><?php echo __('Nous ne spammerons pas votre compte. Définissez vos permissions durant l\'ajout de contenus.');?></small>
		</p>
			<?php
				echo $this->Form->create('User');
				echo $this->Form->input('username',array('label' => __('Nom d\'utilisateur'),'placeholder'=>__('votre nom d\'utilisateur')));
				echo $this->Form->input('email',array('label' => __('Email'),'placeholder'=>__('votre email')));
				echo $this->Form->input('password', array('label' => __('Mot de passe'), 'type' => 'password','placeholder'=>__('votre mot de passe')));

				// echo $this->Form->input('newsletter', array('label' => 'S\'abonner à la newsletter','value' => '1'));
				echo $this->Form->input('captcha',array('label' => __('Combien font 2 + 5 ?'),'placeholder'=>__('2 + 5 = ?')));
				echo $this->Form->submit(__('Continuer'),array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();
			?>
		<div class="row footgrey">
		<p><?php echo $this->Html->link(__('Avez-vous déjà un compte ?'), array('controller'=>'users','action'=>'login')); ?>
			<br/>
			<small><?php echo __('En vous inscrivant, vous acceptez nos');?> <?php echo $this->Html->link(__('Règles d\'utilisation'),array('controller'=>'pages','action'=>'display','cgu')); ?></small></p>
			</div>
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>
