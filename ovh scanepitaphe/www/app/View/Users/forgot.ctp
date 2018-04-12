<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Rappel du mot de passe');?></h3>
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
      <div class="small-12 medium-12 large-12 columns">
      	<p class="footgrey justify"><?php echo __('Si vous avez oublié votre et/ou votre nom d\'utilisateur pour vous connecter, indiquez votre email ci-dessous. Un email de confirmation de demande de nouveau mot de passe vous sera envoyé.');?></p>
		        <?php 
		        	echo $this->Form->create('User'); 
		            echo $this->Form->input('email',array('label' => __('Indiquez votre adresse email'),'placeholder'=>__('votre email'))); 
		            echo $this->Form->submit(__('Regénérer mon mot de passe'),array('class'=>'buttonvioletokfull postfix')); 
    				echo $this->Form->end();
				?>
      </div>
  </div>