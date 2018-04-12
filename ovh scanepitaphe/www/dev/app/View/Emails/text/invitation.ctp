Bonjour,

<?= $user['User']['firstname']; ?> <?= $user['User']['name']; ?> vous invite à rejoindre Scanepitaphe pour gérer la page en mémoire à <?= $personne['Defunt']['firstname']; ?> <?= $personne['Defunt']['name']; ?>.
Pour accepter l'invitation, cliquez sur le lien :
<?= $this->Html->url(array('controller' => 'users', 'action' => 'registerinvit', $email, $personne['Defunt']['id']), true); ?>

Pour tout renseignement, n'hésitez pas à nous contacter : contact@scanepitaphe.fr 

Cordialement,

L'equipe de Scanepitaphe.fr