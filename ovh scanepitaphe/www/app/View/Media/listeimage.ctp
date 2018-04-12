<?php if(empty($medias)) : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Liste des contenus image pour');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('modifier les informations de cette personne')
                  ));?></h3>
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
        <p><?php echo __('Vous n\'avez pas ajouté de contenu image');?></p>
        <?php
            echo '<p>'.__('Il vous reste ').$limit['Limit']['picture'].__(' image(s) à ajouter.').'</p>';
            echo '<p><span class="custom-label bgviolet">'.$this->Html->link(__('Ajouter une image'),array('controller'=>'media','action'=>'addimageind',$personne['Defunt']['id'])).'</span></p>';
        ?>
      </div>
    </div>
</div>
<?php else : ?>
<div class="row minha">
    <div class="row">
        <div class="small-12 medium-12 large-12 columns center">
            <h3><?php echo __('Liste des contenus image pour');?> <?php echo $this->Html->link($personne['Defunt']['firstname'].' '.$personne['Defunt']['name'],array('controller'=>'defunts','action'=>'editprinc',$personne['Defunt']['id']),array(
                    'escapeTitle' => false, 'title' => __('modifier les informations de cette personne')
                  ));?></h3>
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
        <table>
            <tr>
                <th></th>
                <th><?php echo __('Titre');?></th>
                <th><?php echo __('Légende');?></th>
                <th><?php echo __('Catégorie');?></th>
                <th><?php echo __('Album');?></th>
                <th><?php echo __('Commentaires');?></th>
                <th></th>
                <th></th>
            </tr>
             <?php
           
                foreach ($medias as $key => $value) {
                    echo '<tr>';
                    echo '<td>';

                    if(!empty($value['Media']['nomfichier'])){
                        $url = '/medias/defunts/'.'defunt_'.$value['Media']['defunt_id'].'/'.$value['Media']['nomfichier'];
                        echo $this->Image->resize($url, '317', '210');
                    }else{
                        echo $this->Html->Image('http://placehold.it/317x210'); 
                        }
                    echo '</td>';
                    echo '<td>'.$value['Media']['name'].'</td>';
                    echo '<td>'.mb_strimwidth($value['Media']['content'],0,150,"...").'</td>';
                    echo '<td>'.$value['Category']['name'].'</td>';
                    if(!empty($value['Album']['id'])){
                    echo '<td>'.$this->Html->link($value['Album']['name'],array('controller'=>'albums','action'=>'edit',$value['Album']['id'])).'</td>';
                }else{
                    echo '<td></td>';
                }

                    $nbcomments = $this->requestAction('comments/nombre/'.$value['Media']['id']);
                    echo '<td>'.$this->Html->link(__('Voir les ').$nbcomments. __(' commentaire(s)'),array('controller'=>'comments','action'=>'index',$value['Media']['id']));
                    echo '<br/><br/>';

                                //$approbation = $this->Comment->field('approved');
                                if ($value['Media']['comment'] == 0) {
                                    echo $this->Form->postLink(
                                    __('Autoriser les commentaires'),
                                    array('controller'=>'media','action' => 'autcom', $value['Media']['id']),
                                    array('confirm' => __('Etes-vous sûr ?')));                    
                                }
                                if ($value['Media']['comment'] == 1) {
                                    echo $this->Form->postLink(
                                    __('Interdire les commentaires'),
                                    array('controller'=>'media','action' => 'autcom', $value['Media']['id']),
                                    array('confirm' => __('Etes-vous sûr ?')));                    
                                }  
                    echo '</td>';
                    echo '<td>'.$this->Html->link(__('Modifier'),array('controller'=>'media','action'=>'editimage',$value['Media']['id'])).'</td>';
                    echo '<td>'.$this->Html->link(__('Supprimer ce contenu'),array('controller'=>'media','action'=>'deleteimage',$value['Media']['id']),null,__('Voulez vous vraiment supprimer ce contenu ? Cette action est DEFINITIVE.'));
                echo '</td></tr>';
                }
            ?>
        </table>

        <?php
        if($limit['Limit']['text'] == 0){
                echo '<p>'.__('Vous avez atteint votre nombre d\'images autorisées. Rendez-vous dans la boutique pour augmenter ce nombre.').'</p>';
            }else{
            echo '<p>'.__('Il vous reste ').$limit['Limit']['picture'].__(' image(s) à ajouter.').'</p>';
            echo '<p><span class="custom-label bgviolet">'.$this->Html->link(__('Ajouter une image'),array('controller'=>'media','action'=>'addimageind',$personne['Defunt']['id'])).'</span></p>';
        }
        ?>
      </div>
    </div>
</div> 
<?php endif ?>          