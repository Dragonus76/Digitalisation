<?php if(empty($medias)) : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Liste des contenus pdf pour <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'modifier les informations de cette personne'
                  ));?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <p>Vous n'avez pas ajouté de contenu pdf</p>
        <?php
            echo '<p>Il vous reste '.$limit['Limit']['pdf'].' pdf gratuit(s) à ajouter.</p>';
            echo '<p><span class="custom-label bgviolet">'.$this->Html->link('Ajouter un pdf',array('controller'=>'media','action'=>'addpdfind',$personne['Defunt']['id'])).'</span></p>';
        ?>
      </div>
    </div>
</div>
<?php else : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3>Liste des contenus pdf pour <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => 'modifier les informations de cette personne'
                  ));?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                'Retour à la page précédente',
                                $this->request->referer(),
                                array('title'=>'bouton pour revenir à la page précédente')
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 columns">
        <table>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th></th>
                <th></th>
            </tr>
             <?php
                foreach ($medias as $key => $value) {
                    echo '<tr>';
                    echo '<td>'.$value['Media']['name'].'</td>';
                    echo '<td>'.$value['Category']['name'].'</td>';
                    echo '<td>'.$this->Html->link('Modifier',array('controller'=>'media','action'=>'editpdf',$value['Media']['id'])).'</td>';
                    echo '<td>'.$this->Html->link("Supprimer ce contenu",array('controller'=>'media','action'=>'deletepdf',$value['Media']['id']),null,'Voulez vous vraiment supprimer ce contenu ? Cette action est DEFINITIVE.');
                echo ' - ';
                    echo '<a href="#" data-reveal-id="myModal">Commentaires</a>';
                    $comments = $this->requestAction('comments/index/'.$value['Media']['id']);
                        
                    echo '<div id="myModal" class="reveal-modal" data-reveal>
                          <h2>Administration des commentaires pour ce média</h2>';

                    echo  '<table>
                        <tr>
                            <th>Créé le</th>
                            <th>Par</th>
                            <th>Content</th>
                            <th>Statut</th>
                            <th>Valider le commentaire</th>
                        </tr>'; ?>
                    <?php foreach ($comments as $comment): ?>
    <tr>
        <td><?php echo $comment['Comment']['created']; ?></td>
        <td><?php echo $comment['Comment']['autor_name']; ?></td>
        <td><?php echo $comment['Comment']['content']; ?></td>
        <td><?php 
            if($comment['Comment']['approved'] == 1){
                echo 'Approuvé';
            }else{
                echo 'Non approuvé';} ?></td>
        <td>
            <?php 
                //$approbation = $this->Comment->field('approved');
                if ($comment['Comment']['approved'] == 0) {
                    echo $this->Form->postLink(
                    'Approuver',
                    array('controller'=> 'comments','action' => 'approuver', $comment['Comment']['id']),
                    array('confirm' => 'Etes-vous sûr ?'));                    
                }
                if ($comment['Comment']['approved'] == 1) {
                    echo $this->Form->postLink(
                    'Desapprouver',
                    array('controller'=> 'comments','action' => 'approuver', $comment['Comment']['id']),
                    array('confirm' => 'Etes-vous sûr ?'));                    
                }                

            ?> 
            
            <?php echo $this->Form->postLink(
                'Supprimer',
                array('controller'=> 'comments','action' => 'delete', $comment['Comment']['id']),
                array('confirm' => 'Etes-vous sûr ?'));
            ?>            
        </td>        
    </tr>
    <?php endforeach; ?>
    <?php unset($posts); ?>
</table>
                          
                    <?php echo '<a class="close-reveal-modal">&#215;</a>
                        </div>';
                        echo '</td></tr>';

                }
            ?>
        </table>
        <?php
        if($limit['Limit']['text'] == 0){
                echo '<p>Vous avez atteint votre nombre de pdf autorisés. Rendez-vous dans le Scanshop (bientôt disponible) pour augmenter ce nombre.</p>';
            }else{
            echo '<p>Il vous reste '.$limit['Limit']['pdf'].' pdf gratuit(s) à ajouter.</p>';
            echo '<p><span class="custom-label bgviolet">'.$this->Html->link('Ajouter un pdf',array('controller'=>'media','action'=>'addpdfind',$personne['Defunt']['id'])).'</span></p>';
        }
        ?>
      </div>
    </div>
</div>
<?php endif ?>          