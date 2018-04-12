<?php echo __('Bonjour');?>  <?= $user['User']['name']; ?>  <?= $user['User']['firstname']; ?>,

<?php echo __('Un nouveau commentaire vient d\'être posté sur le contenu');?> <?= $media['Media']['name']; ?>.
<?php echo __('Le commentaire n\'est pas encore publié car vous devez l\'approuver auparavant.');?>

<?php echo __('Pour l\'approuver rendez-vous sur cette page :';?> 
<?php if($media['Media']['type']== 'typevideo'){
	echo $this->Html->url(array('controller'=>'media','action'=>'listvideo',$media['Media']['defunt_id']), true);
}elseif($media['Media']['type']== 'typeimage'){
	echo $this->Html->url(array('controller'=>'media','action'=>'listeimage',$media['Media']['defunt_id']), true);
}elseif($media['Media']['type']== 'typeson'){
	echo $this->Html->url(array('controller'=>'media','action'=>'listeson',$media['Media']['defunt_id']), true);
}elseif($media['Media']['type']== 'typetext'){
	echo $this->Html->url(array('controller'=>'media','action'=>'listtext',$media['Media']['defunt_id']), true);
}elseif($media['Media']['type']== 'typepdf'){
	echo $this->Html->url(array('controller'=>'media','action'=>'listepdf',$media['Media']['defunt_id']), true);
}
?>

<?php echo __('Pour tout renseignement, n\'hésitez pas à nous contacter : contact@scanepitaphe.fr');?> 

<?php echo __('Cordialement,');?>

<?php echo __('L\'equipe de Scanepitaphe.fr');?>