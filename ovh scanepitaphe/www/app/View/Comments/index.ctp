<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Liste des Commentaires');?></h3>
        </div>
        <div class="small-12 medium-12 large-12 columns center blacka">
                <h6><i class="fa fa-arrow-circle-left"></i> <?php echo $this->Html->link(
                                __('Retour à la page précédente'),
                                $this->request->referer(),
                                array('title'=>__('bouton pour revenir à la page précédente'))
                                ); ?></h6>
        </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 columns">

        <?php if(!empty($comments)) : ?>
            <table>
                <tr>
                    
                    <th><?php echo __('Créé le');?></th>
                    <th><?php echo __('Par'); ?> </th>
                    <th><?php echo __('Content');?></th>
                    <th><?php echo __('Valider le commentaire');?></th>
                    <th><?php echo __('Supprimer');?></th>
                </tr>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        
                     
                        <td><?php echo $comment['Comment']['created']; ?></td>
                        <td><?php echo $comment['Comment']['autor_name']; ?></td>
                        <td><?php echo $comment['Comment']['content']; ?></td>
                        <td>
                            <?php 
                                //$approbation = $this->Comment->field('approved');
                                if ($comment['Comment']['approved'] == 0) {
                                    echo $this->Form->postLink(
                                    'Approuver',
                                    array('action' => 'approuver', $comment['Comment']['id']),
                                    array('confirm' => __('Etes-vous sûr ?')));                    
                                }
                                if ($comment['Comment']['approved'] == 1) {
                                    echo $this->Form->postLink(
                                    'Desapprouver',
                                    array('action' => 'approuver', $comment['Comment']['id']),
                                    array('confirm' => __('Etes-vous sûr ?')));                    
                                }  
                            ?>
                        </td><td>
                            <?php
                            echo $this->Form->postLink(
                                'Supprimer',
                                array('action' => 'delete', $comment['Comment']['id']),
                                array('confirm' => __('Etes-vous sûr ?')));
                            ?>            
                        </td>        
                    </tr>
                <?php endforeach; ?>
                <?php unset($posts); ?>
            </table>
<?php else: ?>
    <p><?php echo __('Aucun commentaire sur ce contenu.');?></p>
<?php endif ?>
      </div>
  </div>
</div>