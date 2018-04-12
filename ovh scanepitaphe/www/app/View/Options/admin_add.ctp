<div class="row">
	<h5>Ajouter un élément de menu</h5>
	<div class="small-12 medium-6 large-6 columns">
		<h6>Informations sur l'élément</h6>
		<?php
			echo $this->Form->create('Menu',array('type' => 'file'));
			echo $this->Form->input('name',array('label' => 'Nom'));
			echo $this->Form->input('slug',array('label' => 'Lien'));
		?>
	</div>
	<div class="small-12 medium-6 large-6 columns">
		<?php
			echo $this->Form->input('topmenu',array('label' => 'Placer dans le menu principal'));
			echo $this->Form->input('position',array('label' => 'Position dans le menu principal'));
			echo $this->Form->input('footerleft',array('label' => 'Mettre dans le pied de page gauche'));
			echo $this->Form->input('footermid',array('label' => 'Mettre dans le pied de page milieu'));
			echo $this->Form->input('footerright',array('label' => 'Mettre dans le pied de page droite'));
		?>
	</div>
	<div class="small-12 medium-12 large-12 columns">
		<?php
			echo $this->Form->submit('Ajouter l\'élément',array('class'=>'button postfix')); 
    	echo $this->Form->end();
    	?>
	</div>
</div>

	