<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
	<h1>Editer la page</h1>
<?php
echo $this->Form->create('Page');

echo $this->Form->input('id', array('type' => 'hidden'));
foreach (Configure::read('Config.languages') as $lang) {
echo $this->Form->input('Page.title.'.$lang, array('label' => 'Titre de la page'.' ('.$lang.')'));
}
if($page['Page']['id']==10){
echo $this->Form->input('content',array('label' => 'Numéro d\'identifiant de la vidéo (exemple: 5g67r3FUJE8)'));
}else{
	foreach (Configure::read('Config.languages') as $lang) {
echo $this->Form->textarea('Page.content.'.$lang, array('label' => 'Contenu de la page'.' ('.$lang.')','class' => 'ckeditor'));
echo '<br/>';
}
}
echo $this->Form->end('Enregister les modifications');
?>
	</div>
</div>