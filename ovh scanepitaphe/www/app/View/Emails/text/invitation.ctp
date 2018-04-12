<?php echo __('Bonjour,');?>

<?= $user['User']['firstname']; ?> <?= $user['User']['name']; ?> <?php echo __('vous invite à rejoindre Scanepitaphe pour gérer la page en mémoire à');?> <?= $personne['Defunt']['firstname']; ?> <?= $personne['Defunt']['name']; ?>.
<?php echo __('Pour accepter l\'invitation, cliquez sur le lien :');?>
<?= $this->Html->url(array('controller' => 'users', 'action' => 'registerinvit', $email, $personne['Defunt']['id']), true); ?>

<?php echo __('Pour tout renseignement, n\'hésitez pas à nous contacter : contact@scanepitaphe.fr');?>

<?php echo __('Cordialement,')?>

<?php echo __('L\'equipe de Scanepitaphe.fr');?>