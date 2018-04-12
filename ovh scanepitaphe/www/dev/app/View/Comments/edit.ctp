<!-- POSTS -->
<div class="clientpages">
    
<h1>Editer le post</h1>
<?php
echo $this->Form->create('Comment');
echo $this->Form->input('autor_name');
echo $this->Form->input('email_auteur');
echo $this->Form->input('title');
echo $this->Form->input('content', array('rows' => '3'));
echo $this->Form->end('Sauvegarder le commentaire');
?>

</div><!-- clientpages -->