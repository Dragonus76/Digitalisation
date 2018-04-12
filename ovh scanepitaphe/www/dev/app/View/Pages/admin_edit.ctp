<div class="row minha">
	<?php echo $this->element('bordadmin'); ?>
    <div class="small-12 medium-8 large-8 columns">
	<h1>Editer la page</h1>
<?php
echo $this->Form->create('Page');
echo $this->Form->input('title',array('label' => 'Titre de la page'));
if($page['Page']['id']==10){
echo $this->Form->input('content',array('label' => 'Numéro d\'identifiant de la vidéo (exemple: 5g67r3FUJE8)'));
}else{
echo $this->Form->input('content',array('label' => 'Contenu de la page','class' => 'ckeditor'));
}
echo $this->Form->end('Enregister les modifications');
?>
	</div>
</div>