<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
    	<h2>Ajouter un mode de livraison</h2>
<?php
echo $this->Form->create('Delivery');
echo $this->Form->input('name', array('label' => '1 - Définissez le nom du mode de livraison'));
echo $this->Form->input('value', array('label' => '2 - Ajouter le prix'));
$zone =array('France' => 'France','Europe zone 1'=>'Europe zone 1','Europe zone 2'=>'Europe zone 2','Europe zone 2 et 3'=>'Europe zone 2 et 3','Etats Unis'=>'Etats Unis');
echo $this->Form->input('zone', array('label' => '3 - Choisir la zone concernée','options'=>$zone));
echo $this->Form->submit('Ajouter ce mode de livraison',array('class'=>'button postfix')); 
            echo $this->Form->end();
?>
</div>
</div>