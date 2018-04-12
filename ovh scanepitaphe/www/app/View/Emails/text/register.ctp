<?php echo __('Bonjour');?> <?= $username; ?>,

<?php echo __('Nous vous remercions pour votre inscription au site Scanepitaphe.fr.');?>
<?php echo __('Vous pouvez valider votre compte en vous rendant lien');?>
<?= $this->Html->url(array('controller' => 'users', 'action' => 'activate', $id, $token), true); ?>

<?php echo __('Cordialement,');?>

<?php echo __('L\'equipe de Scanepitaphe.fr');?>