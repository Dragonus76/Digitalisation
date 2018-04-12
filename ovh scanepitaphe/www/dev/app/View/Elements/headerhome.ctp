<div class="headerhome">
	<div class="bandeau">
	<div class="logohome small-12 medium-3 large-3 columns">
		<?php 
    echo $this->Html->image('logo-home.png', 
              array(
                'alt' => 'logo retour accueil du site',
                'width'=>'150',

                'url' => array('controller' => 'pages', 'action' => 'display', 'home','admin'=>false)
                )); 
     ?>
	</div>
	
	<div class="menuhome small-12 medium-9 large-9 columns">
		<?php if ($this->Session->read('Auth.User.id')): ?>
			<ul>
				<li>
					<?php 
						echo $this->Html->link(
					 		'Mon compte',
					 		array(
					 			'controller' => 'users', 
					 			'action' => 'account',
					 			'admin'=>false
					 			),
					 		array(
				              'escapeTitle' => false, 'title' => 'aller à votre compte'
				            ));
					?>
				</li>
				<li>
					<?php 
						echo $this->Html->link(
					 		'Se déconnecter',
					 		array(
					 			'controller' => 'users', 
					 			'action' => 'logout',
					 			'admin'=>false
					 			),
					 		array(
				              'escapeTitle' => false, 'title' => 'se déconnecter'
				            ));
					?>
				</li>
			</ul>
		<?php else: ?>
			<ul>
				<li>
					<?php 
						echo $this->Html->link(
					 		'Se connecter',
					 		array(
					 			'controller' => 'users', 
					 			'action' => 'login',
					 			'admin'=>false
					 			),
					 		array(
				              'escapeTitle' => false, 'title' => 'se connecter à votre compte'
				            ));
					?>
				</li>
				<li>
					<?php 
						echo $this->Html->link(
					 		'S\'inscrire gratuitement',
					 		array(
					 			'controller' => 'users', 
					 			'action' => 'register',
					 			'admin'=>false
					 			),
					 		array(
				              'escapeTitle' => false, 'title' => 's\'inscrire gratuitement pour créer votre compte'
				            ));
					?>
				</li>
				
			</ul>
		<?php endif ?>
	</div>
	</div>
</div>