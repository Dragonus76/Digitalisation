<?php echo __('Bonjour,');?>

<?php echo __('Vous avez demandez à regénérer votre mot de passe pour le site Scanepitaphe.fr. Si vous êtes bien à l\'origine de cette demande merci de suivre ce lien');?>
<?= $this->Html->url(array('controller' => 'users', 'action' => 'password', $id, $token), true); ?>

<?php echo __('Pour rappel votre nom d\'utilisateur :');?> <?= $username; ?>


<?php echo __('Cordialement,');?>


<?php echo __('L\'équipe de Scanepitaphe');?>