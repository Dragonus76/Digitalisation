<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
	<div class="small-12 medium-8 large-8 columns">
	<h4>Modifier <?php echo $this->request->data['Option']['name'];?></h4>
		<?php
			echo $this->Form->create('Option');
			echo $this->Form->input('id', array('label' => 'Identifiant'));
			echo $this->Form->input('name',array('label' => 'Nom'));
	
			$val=array(3,9,10);
			if(in_array($fiche['Option']['id'], $val)){
				echo $this->Form->input('content', array('label' => 'Contenu','row' => '3'));
			}else{
				echo $this->Form->input('content', array('label' => 'Contenu','row' => '3','class' => 'ckeditor'));
				}
	
		?>

		<?php
			echo $this->Form->submit('Modifier',array('class'=>'button postfix')); 
    	echo $this->Form->end();
    	?>
	</div>

</div>

	