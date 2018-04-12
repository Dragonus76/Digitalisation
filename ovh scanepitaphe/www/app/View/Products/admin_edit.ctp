<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
    	<h2>Modifier un produit</h2>
<?php
echo $this->Form->create('Product',array('type' => 'file'));
echo $this->Form->input('id', array('type' => 'hidden'));
foreach (Configure::read('Config.languages') as $lang) {
echo $this->Form->input('Product.name.'.$lang, array('label' => 'Définissez le nom du produit ('.$lang.')'));
}
foreach (Configure::read('Config.languages') as $lang) {
echo $this->Form->input('Product.content.'.$lang, array('label' => 'Ajouter une description ('.$lang.')','rows' => '3'));
}
$type = array(1 => 'Produit matériel',2 => 'Extension');
echo $this->Form->input('type', array(
                      'label' => 'Choississez un type de produit',
                      'options' => $type));
echo $this->Form->input('text', array('label' => 'Nombre de textes supplémentaires autorisés'));
echo $this->Form->input('picture', array('label' => 'Nombre de fichiers image supplémentaires autorisés'));
echo $this->Form->input('sound', array('label' => 'Nombre de fichiers sonores supplémentaires autorisés'));
echo $this->Form->input('pdf', array('label' => 'Nombre de fichiers pdf supplémentaires autorisés'));
if($this->request->data['Product']['thumbnail']){
echo $this->Html->image('products/'.$this->request->data['Product']['thumbnail']);}
echo $this->Form->input('thumbnail_file',array('label' => 'Choix de la vignette', 'type' => 'file'));
echo $this->Form->input('price', array('label' => 'Prix HT du produit'));
echo $this->Form->input('tva', array('label' => 'Taux de TVA applicable à ce produit'));

echo $this->Form->input('nupload', array('label' => 'Cocher si ce produit implique le chargement d\'une image pour l\'utisateur'));


echo $this->Form->submit('Modifer ce produit',array('class'=>'button postfix')); 
            echo $this->Form->end();
?>
</div>
</div>