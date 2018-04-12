<div class="row">
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
	<div class="small-12 medium-6 large-6 columns borderone">
		<h2 class="robotobold">Inscription</h2>
		<p class="grey">Ecrivez vos mémoires ou celles de vos proches. Partagez vos souvenirs</p>
		<p class="grey">
			<small>Nous ne spammerons pas votre compte. Définissez vos permissions durant l'ajout de contenus.</small>
		</p>
			<?php
				echo $this->Form->create('User');
				echo $this->Form->input('username',array('label' => 'Nom d\'utilisateur','placeholder'=>'votre nom d\'utilisateur'));
				echo $this->Form->input('email',array('label' => 'Email','placeholder'=>'votre email'));
				echo $this->Form->input('password', array('label' => 'Mot de passe', 'type' => 'password','placeholder'=>'votre mot de passe'));

				// echo $this->Form->input('newsletter', array('label' => 'S\'abonner à la newsletter','value' => '1'));
				echo $this->Form->input('captcha',array('label' => 'Combien font 2 + 5 ?','placeholder'=>'2 + 5 = ?'));
				echo $this->Form->submit('Continuer',array('class'=>'buttonvioletokfull postfix')); 
    			echo $this->Form->end();
			?>
		<div class="row footgrey">
		<p><?php echo $this->Html->link('Avez-vous déjà un compte ?', array('controller'=>'users','action'=>'login')); ?>
			<br/>
			<small>En vous inscrivant, vous acceptez nos <?php echo $this->Html->link('Règles d\'utilisation',array('controller'=>'pages','action'=>'display','cgu')); ?></small></p>
			</div>
	</div>
	<div class="small-12 medium-3 large-3 columns">
		&nbsp;
	</div>
</div>
