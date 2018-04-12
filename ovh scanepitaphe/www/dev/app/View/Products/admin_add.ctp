<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
    	<h2>Ajouter un produit</h2>
<?php
echo $this->Form->create('Product',array('type' => 'file'));
echo $this->Form->input('name', array('label' => '1 - Définissez le nom du produit'));
echo $this->Form->input('content', array('label' => '2 - Ajouter une description','rows' => '3'));
$type = array(1 => 'Produit matériel',2 => 'Extension');
echo $this->Form->input('type', array(
                      'label' => '3 - Choississez un type de produit',
                      'options' => $type));
echo $this->Form->input('text', array('label' => '4 - Nombre de textes supplémentaires autorisés'));
echo $this->Form->input('picture', array('label' => '5 - Nombre de fichiers image supplémentaires autorisés'));
echo $this->Form->input('sound', array('label' => '6 - Nombre de fichiers sonores supplémentaires autorisés'));
echo $this->Form->input('pdf', array('label' => '7 - Nombre de fichiers pdf supplémentaires autorisés'));
echo $this->Form->input('thumbnail_file',array('label' => '8 - Choix de la vignette', 'type' => 'file'));
echo $this->Form->input('price', array('label' => '9 - Prix HT du produit'));
echo $this->Form->input('tva', array('label' => '10 - Taux de TVA applicable à ce produit'));

echo $this->Form->input('nupload', array('label' => '11 - Cocher si ce produit implique le chargement d\'une image pour l\'utisateur'));

echo $this->Form->submit('Ajouter ce produit',array('class'=>'button postfix')); 
            echo $this->Form->end();
?>
</div>
</div>