<!-- POSTS -->
<div class="clientpages">
	

<h1>Liste des Commentaires</h1>


<?php
//print_r($clientpages);
?>

<?php 
    echo $this->Html->link(
    'Ajouter un Commentaire', array('controller' => 'Comments','action' => 'add')
    );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Titre</th>
        <th>Créé le</th>
        <th>Par</th>
        <th>e-mail</th>
        <th>Content</th>
        <th>Valider le commentaire</th>
    </tr>

   

    <?php foreach ($comments as $comment): ?>
    <tr>
        <td><?php echo $comment['Comment']['id']; ?></td>
        <td>
			<?php echo $this->Html->link($comment['Comment']['title'],
            array('controller' => 'Posts', 'action' => 'view', $comment['Comment']['id'])); ?>
        </td>
        <td><?php echo $comment['Comment']['created']; ?></td>
        <td><?php echo $comment['Comment']['autor_name']; ?></td>
        <td><?php echo $comment['Comment']['email_auteur']; ?></td>
        <td><?php echo $comment['Comment']['content']; ?></td>
        <td><?php echo $comment['Comment']['approved']; ?></td>
        <td>
            <?php 
                //$approbation = $this->Comment->field('approved');
                if ($comment['Comment']['approved'] == 0) {
                    echo $this->Form->postLink(
                    'Approuver',
                    array('action' => 'approuver', $comment['Comment']['id']),
                    array('confirm' => 'Etes-vous sûr ?'));                    
                }
                if ($comment['Comment']['approved'] == 1) {
                    echo $this->Form->postLink(
                    'Desapprouver',
                    array('action' => 'approuver', $comment['Comment']['id']),
                    array('confirm' => 'Etes-vous sûr ?'));                    
                }                

            ?> 
            <?php echo $this->Html->link(
                'Editer',
                array('action' => 'edit', $comment['Comment']['id'])
            ); ?>
            <?php echo $this->Form->postLink(
                'Supprimer',
                array('action' => 'delete', $comment['Comment']['id']),
                array('confirm' => 'Etes-vous sûr ?'));
            ?>            
        </td>        
    </tr>
    <?php endforeach; ?>
    <?php unset($posts); ?>
</table>


</div><!-- clientpages -->