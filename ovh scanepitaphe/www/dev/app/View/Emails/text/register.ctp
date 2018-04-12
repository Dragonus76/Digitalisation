Bonjour <?= $username; ?>,

Nous vous remercions pour votre inscription au site Scanepitaphe.fr.
Vous pouvez valider votre compte en vous rendant lien
<?= $this->Html->url(array('controller' => 'users', 'action' => 'activate', $id, $token), true); ?>

Cordialement,

L'equipe de Scanepitaphe.fr