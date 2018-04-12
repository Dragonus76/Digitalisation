<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
    	<h2>Modifier un mode de livraison</h2>
<?php
echo $this->Form->create('Delivery');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('name', array('label' => '1 - Définissez le nom du mode livraison'));
echo $this->Form->input('value', array('label' => '2 - Prix'));

echo $this->Form->submit('Modifer ce mode de livraison',array('class'=>'button postfix')); 
            echo $this->Form->end();
?>
</div>
</div>