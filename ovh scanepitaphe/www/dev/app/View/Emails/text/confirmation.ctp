Bonjour  <?= $name; ?>  <?= $firstname; ?>,

Nous vous remercions pour votre achat sur le site Scanepitaphe.fr.
Vous pouvez désormais profiter pleinement de votre produit ScanEpitaphe en vous rendant sur votre compte :
<?= $this->Html->url(array('controller' => 'users', 'action' => 'account', $id), true); ?>

A partir de votre compte, vous pourrez télécharger votre facture.

Nous vous rappelons votre login pour vous connecter sur notre site : <?= $username; ?> 

Pour tout renseignement, n'hésitez pas à nous contacter : contact@scanepitaphe.fr 

Cordialement,

L'equipe de Scanepitaphe.fr