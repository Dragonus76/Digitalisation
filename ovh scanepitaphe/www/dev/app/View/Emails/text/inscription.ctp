Bonjour  <?= $username; ?>,

Nous vous remercions pour votre inscription au site Scanepitaphe.fr.
Activez votre compte en cliquant sur le lien ci-desous :
<?= $this->Html->url(array('controller' => 'users', 'action' => 'activate', $id, $token), true); ?>

Cordialement,

L'equipe de Scanepitaphe.fr