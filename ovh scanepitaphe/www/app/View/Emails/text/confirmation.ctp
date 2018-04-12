<?php echo __('Bonjour');?>  <?= $name; ?>  <?= $firstname; ?>,

<?php echo __('Nous vous remercions pour votre achat sur le site Scanepitaphe.fr.');?>
<?php echo __('Vous pouvez désormais profiter pleinement de votre produit ScanEpitaphe en vous rendant sur votre compte :');?>
<?= $this->Html->url(array('controller' => 'users', 'action' => 'account', $id), true); ?>

<?php echo __('A partir de votre compte, vous pourrez télécharger votre facture.');?>

<?php echo __('Nous vous rappelons votre login pour vous connecter sur notre site :');?> <?= $username; ?> 

<?php echo __('Pour tout renseignement, n\'hésitez pas à nous contacter : contact@scanepitaphe.fr');?>

<?php echo __('Cordialement,');?>

<?php echo __('L\'equipe de Scanepitaphe.fr');?>